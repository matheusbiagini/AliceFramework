<?php

declare(strict_types=1);

namespace Infrastructure\Database;

use Doctrine\DBAL\DriverManager;
use Infrastructure\Kernel\Configuration;
use Infrastructure\Kernel\ServiceContainer;

class Connection
{
    /** @var Configuration $configuration */
    private $configuration;

    /** @var \PDO */
    private static $PDO;

    /** @var \Doctrine\DBAL\Connection */
    private static $DBAL_CONNECTION;

    /** @var Connection */
    private static $CONNECTION_INSTANCE;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        self::$PDO = $this->createPdo();
        self::$DBAL_CONNECTION = $this->createDbalConnection();
    }

    public static function getInstance() : self
    {
        if (self::$CONNECTION_INSTANCE === null) {
            self::$CONNECTION_INSTANCE = new self(ServiceContainer::getConfiguration());
        }

        return static::$CONNECTION_INSTANCE;
    }

    public function createPdo() : \PDO
    {
        $host       = $this->configuration->get('MYSQL_HOST', 'mysql');
        $database   = $this->configuration->get('MYSQL_DATABASE', '');
        $user       = $this->configuration->get('MYSQL_USER', 'root');
        $password   = $this->configuration->get('MYSQL_ROOT_PASSWORD', '');

        return new \PDO(
            sprintf("mysql:dbname=%s;host=%s;charset=utf8", $database, $host),
            $user,
            $password,
            array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '".$this->getTimezone()."'"
            )
        );
    }

    public function getPdo() : \PDO
    {
        return self::$PDO;
    }

    public function getConnection(): \Doctrine\DBAL\Connection
    {
        return self::$DBAL_CONNECTION;
    }

    public function createDbalConnection(): \Doctrine\DBAL\Connection
    {
        return DriverManager::getConnection(
            array('pdo' => $this->getPdo()),
            new \Doctrine\DBAL\Configuration()
        );
    }

    private function getTimezone() : string
    {
        $now = new \DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = ($mins < 0 ? -1 : 1);
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;

        return sprintf('%+d:%02d', $hrs*$sgn, $mins);
    }

    public function identifier() : string
    {
        return '#ID.' . rand(1, 200000);
    }

    public static function close()
    {
        self::$CONNECTION_INSTANCE = null;
        self::$PDO = null;
        self::$DBAL_CONNECTION = null;
    }

    public function __destruct()
    {
        self::close();
    }
}
