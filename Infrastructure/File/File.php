<?php

declare(strict_types=1);

namespace Infrastructure\File;

interface File
{
    public function upload(\Infrastructure\File\ValueObject\File $file) : bool;
    public function getFileLink() : string;
}
