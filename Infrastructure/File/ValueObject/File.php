<?php

declare(strict_types=1);

namespace Infrastructure\File\ValueObject;

class File
{
    /** @var $_FILES $file*/
    private $file;

    /** @var string $dir*/
    private $dir;

    /** @var int $maxsize*/
    private $maxsize;

    public function __construct(array $file, string $dir, int $maxsize = 2000000)
    {
        $this->file     = $file;
        $this->dir      = $dir;
        $this->maxsize  = $maxsize;
    }

    public function getDir() : string
    {
        return $this->dir;
    }

    public function getFile() : array
    {
        return $this->file;
    }

    public function getTemp() : string
    {
        return $this->getFile()['tmp_name'] ?? '';
    }

    public function getName() : string
    {
        return $this->getFile()['name'] ?? '';
    }

    public function getContent() : string
    {
        return file_get_contents($this->getTemp());
    }

    public function getSize() : int
    {
        return $this->getFile()['size'] ?? 0;
    }

    public function getType() : int
    {
        return $this->getFile()['type'] ?? 0;
    }

    public function getMaxsize() : int
    {
        return $this->maxsize;
    }

    public function getMaxSizeFormat(string $keyUnity = "MB") : string
    {
        $unity = array (
            'B' => 1,
            'KB' => 1000, 'MB' => 1000000, 'GB' => 1000000000, 'TB' => 1000000000,
            'KiB' => 1024, 'MiB' => 1048576, 'GiB' => 1073741824, 'TiB' => 1099511627776
        );

        return round($this->getMaxsize() * $unity['B'] / $unity[$keyUnity], 2) . $keyUnity;
    }
}
