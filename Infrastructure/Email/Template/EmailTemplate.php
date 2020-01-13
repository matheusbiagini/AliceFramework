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

    public static function resetPassword(string $email, string $newPassword) : string
    {
        $template = self::getTemplate('resetPassword.html');

        return str_replace(
            ['{{hello}}', '{{subject}}', '{{password}}', '{{newPassword}}'],
            [translate('HELLO'), translate('EMAIL_RESET_PASSWORD', ['{{email}}' => $email]), translate('PASSWORD'), $newPassword],
            $template
        );
    }

    public static function codeAccessMultiFactor(string $email, string $name, string $codeAccess) : string
    {
        $template = self::getTemplate('codeAccessMultiFactor.html');

        return str_replace(
            ['{{hello}}', '{{name}}', '{{subject}}', '{{password}}', '{{newPassword}}'],
            [translate('HELLO'), $name, translate('EMAIL_CODE_ACCESS_MULTI_FACTOR', ['{{email}}' => $email]), translate('CODE_ACCESS_MULTI_FACTOR'), $codeAccess],
            $template
        );
    }

    public static function contact(
        ?string $name,
        ?string $email,
        ?string $subject,
        ?string $phoneDDD,
        ?string $phone,
        ?string $message,
        ?string $site,
        ?string $country
    ) : string {
        $template = self::getTemplate('emailContact.html');

        $siteReal = $site;
        $name = sprintf("%s: %s", translate('NAME'), $name);
        $email = sprintf("%s: %s", translate('EMAIL'), $email);
        $phoneDDD = sprintf("%s: %s", translate('PHONE'), $phoneDDD);
        $message = sprintf("%s: %s", translate('MESSAGE'), $message);
        $subject = sprintf("%s: %s", translate('SUBJECT'), $subject);
        $country = sprintf("%s: %s", translate('ADDRESS_COUNTRY'), $country);
        $site = sprintf("%s: %s", translate('SITE'), $site);

        return str_replace(
            ['{{message_email}}', '{{message}}', '{{site}}', '{{name}}', '{{email}}', '{{subject}}', '{{phone_ddd}}', '{{phone}}', '{{country}}'],
            [translate('SEND_EMAIL_CONTACT_MESSAGE', ['{{site}}' => $siteReal]), $message, $site, $name, $email, $subject, $phoneDDD, $phone, $country],
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
