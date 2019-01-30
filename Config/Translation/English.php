<?php

declare(strict_types=1);

namespace Config\Translation;

use Infrastructure\Translation\Translation;

class English implements Translation
{
    public function getKey(): string
    {
        return 'en';
    }

    public function translations(): array
    {
        return [
            'NAME' => 'Name',
            'EMAIL' => 'Email',
            'PASSWORD' => 'Password',
            'PHONE' => 'Phone',
            'PHONE_RES' => 'Home Phone',
            'PHONE_COM' => 'Commercial phone',
            'PHONE_CEL' => 'Cell phone',
            'FILE' => 'File',
            'LOADING' => 'Loading',
            'SUCCESSFULLY' => 'Success',
            'FILE_MESSAGE_SENT_WITH_SUCCESS' => 'File {{fileName}} uploaded successfully.',
            'ERROR_MAXSIZE_FILE' => 'File size can not exceed {{maxSizeFormat}}.',
            'ERROR_TYPES_ACCEPT_FILE' => 'Extension {{extension}} not allowed.',
            'ERROR_FILENAME_FILE' => 'There was an error submitting the file {{fileName}}.',
        ];
    }
}
