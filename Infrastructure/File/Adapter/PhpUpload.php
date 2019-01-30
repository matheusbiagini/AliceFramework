<?php

declare(strict_types=1);

namespace Infrastructure\File\Adapter;

use Infrastructure\File\File;

class PhpUpload implements File
{
    /** @var string $link */
    private $link;

    public function upload(\Infrastructure\File\ValueObject\File $file) : bool
    {
        $this->link = '/Upload' . $file->getDir() . $this->generateFileName($file->getName());

        return move_uploaded_file(
            $file->getTemp(),
            PATH_ROOT . sprintf("/web%s", $this->getFileLink())
        );
    }

    public function getFileLink() : string
    {
        return $this->link;
    }

    private function generateFileName(string $name) : string
    {
        return 'file-'.time().'-'.$name;
    }
}
