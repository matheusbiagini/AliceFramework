<?php

declare(strict_types=1);

namespace Infrastructure\Email\Template;

abstract class EmailTemplate
{
    public static function forgotPassword(string $email, string $name, string $newPassword) : string
    {
        $template = self::getTemplate('forgotPassword.html');

        return str_replace(
            ['{{hello}}', '{{name}}', '{{subject}}', '{{password}}', '{{newPassword}}'],
            [translate('HELLO'), $name, translate('EMAIL_FORGOT_PASSWORD', ['{{email}}' => $email]), translate('PASSWORD'), $newPassword],
            $template
        );
    }

    public static function getTemplate(string $templateName) : string
    {
        return file_get_contents(self::pathTemplates() . $templateName);
    }

    private static function pathTemplates() : string
    {
        return PATH_ROOT . '/App/View/Template/Email/';
    }
}
