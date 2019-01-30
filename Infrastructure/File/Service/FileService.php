<?php

declare(strict_types=1);

namespace Infrastructure\File\Service;

use Infrastructure\File\Adapter\PhpUpload;

class FileService
{
    /** @var \Infrastructure\File\File $fileInterface */
    private $fileAdapter;

    public function __construct()
    {
        $this->fileAdapter = new PhpUpload();
    }

    public function push(\Infrastructure\File\ValueObject\File $file) : ?string
    {
        $bool = $this->fileAdapter->upload($file);

        if ($bool === false) {
            return null;
        }

        return $this->fileAdapter->getFileLink();
    }
}
