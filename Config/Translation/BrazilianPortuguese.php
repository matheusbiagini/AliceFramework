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
            'HELLO' => 'Olá',
            'SIGN_IN_TO_CONTINUE' => 'Entre para continuar',
            'SIGN_IN' => 'Entrar',
            'FORGOT_PASSWORD' => 'Esqueci a senha',
            'BUTTON_FORGOT_PASSWORD' => 'Solicitar nova senha',
            'BACK' => 'Voltar',
            'KEEP_ME_SIGNED_IN' => 'Continuar conectado',
            'DONT_HAVE_AN_ACCOUNT' => 'Você não tem uma conta',
            'CREATE' => 'Criar',
            'CONNECT_USING_FACEBOOK' => 'Conectar usando o facebook',
            'EMAIL_FORGOT_PASSWORD' => 'Você solicitou o esqueci minha senha e por isso estamos enviando no email informado: {{email}}, uma senha provisória para você',
            'PASSWORD_REQUEST_SENT_TO_SUCCESS' => 'Solicitação de senha enviada com sucesso. Consulte seu e-mail para ver a nova senha provisória.',
            'SIGNOUT' => 'Sair',
            'EDIT_MY_PROFILE' => 'Editar meus dados',
            'PROFILE_ADMIN' => 'Administrador',
            'PROFILE_USER' => 'Usuário comum',
            'STATUS_EXCLUDED' => 'Excluído',
            'STATUS_ACTIVE' => 'Ativo',
            'STATUS_DISABLED' => 'Desativado',
        ];
    }
}
