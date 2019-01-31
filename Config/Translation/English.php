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
            'HELLO' => 'Hello',
            'SIGN_IN_TO_CONTINUE' => 'Sign in to continue',
            'SIGN_IN' => 'Sign in',
            'FORGOT_PASSWORD' => 'Forgot password',
            'BUTTON_FORGOT_PASSWORD' => 'Request new password',
            'BACK' => 'Back',
            'KEEP_ME_SIGNED_IN' => 'Keep me signed in',
            'DONT_HAVE_AN_ACCOUNT' => 'Don\'t have an account',
            'CREATE' => 'Create',
            'CONNECT_USING_FACEBOOK' => 'Connect using facebook',
            'EMAIL_FORGOT_PASSWORD' => 'You have requested the I forgot my password and so we are sending a temporary password to you',
            'PASSWORD_REQUEST_SENT_TO_SUCCESS' => 'Password request sent to success. Check your email to see the temporary password.',
            'SIGNOUT' => 'Sign out',
            'EDIT_MY_PROFILE' => 'Edit profile',
            'PROFILE_ADMIN' => 'Admin',
            'PROFILE_USER' => 'Common User',
            'STATUS_EXCLUDED' => 'Excluded',
            'STATUS_ACTIVE' => 'Active',
            'STATUS_DISABLED' => 'Disabled',
        ];
    }
}
