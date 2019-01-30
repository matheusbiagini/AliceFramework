<?php

declare(strict_types=1);

namespace Config\Translation;

use Infrastructure\Translation\Translation;

class BrazilianPortuguese implements Translation
{
    public function getKey(): string
    {
        return 'pt-br';
    }

    public function translations(): array
    {
        return [
            'NAME' => 'Nome',
            'EMAIL' => 'E-mail',
            'PASSWORD' => 'Senha',
            'PHONE' => 'Telefone',
            'PHONE_RES' => 'Telefone Residencial',
            'PHONE_COM' => 'Telefone Comercial',
            'PHONE_CEL' => 'Telefone Celular',
            'FILE' => 'Arquivo',
            'LOADING' => 'Carregando',
            'SUCCESSFULLY' => 'Sucesso',
            'FILE_MESSAGE_SENT_WITH_SUCCESS' => 'Arquivo {{fileName}} enviado com successo.',
            'ERROR_MAXSIZE_FILE' => 'Tamanho do arquivo não pode ultrapassar a {{maxSizeFormat}}.',
            'ERROR_TYPES_ACCEPT_FILE' => 'Extensão {{extension}} não permitida.',
            'ERROR_FILENAME_FILE' => 'Houve um erro ao enviar o arquivo {{fileName}}.',
        ];
    }
}
