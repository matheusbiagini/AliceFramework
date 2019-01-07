<?php

declare(strict_types=1);

namespace Infrastructure\Database;

use Doctrine\DBAL\DriverManager;
use Infrastructure\Kernel\Configuration;

class Connection
{
    /** @var Configuration $configuration */
    private $configuration;

    /** @var Connection */
    private static $CONNECTION_INSTANCE;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public static function getInstance() : self
    {
        if (self::$CONNECTION_INSTANCE === null) {
            self::$CONNECTION_INSTANCE = new self(new Configuration());
        }

        return static::$CONNECTION_INSTANCE;
    }

    public function getPdo() : \PDO
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

    /** return dbal instance */
    public function getConnection(): \Doctrine\DBAL\Connection
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
}
