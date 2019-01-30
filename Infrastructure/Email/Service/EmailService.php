<?php

declare(strict_types=1);

namespace Infrastructure\Email\Service;

use Infrastructure\Email\Exception\ErrorSendingEmail;
use Infrastructure\Kernel\Configuration;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PhpMailerException;

class EmailService
{
    private $mailer;
    private $mailerHost;
    private $mailerFrom;
    private $mailerPassword;
    private $mailerEncryption;

    private $body;
    private $subject;
    private $to = [];
    private $toName = [];
    private $from = "";
    private $fromName;
    private $replyTo;
    private $replyToName;
    private $cc = [];
    private $ccName;
    private $bccTo;
    private $bccToName;
    private $attachment;

    public function __construct(Configuration $configuration)
    {
        $this->mailerHost       = $configuration->get('MAILER_HOST');
        $this->mailerFrom       = $configuration->get('MAILER_FROM_EMAIL');
        $this->mailerPassword   = $configuration->get('MAILER_FROM_PASSWORD');
        $this->mailerEncryption = $configuration->get('MAILER_ENCRYPTION', 'tls');
    }

    public function addBody(string $body) : self
    {
        $this->body = $body;
        return $this;
    }

    public function addSubject(string $subject) : self
    {
        $this->subject = $subject;
        return $this;
    }

    public function addTo(string $email, string $name = "") : self
    {
        $this->to[] = $email;
        $this->toName[] = $name;
        return $this;
    }

    public function addFrom(string $email, string $name = "") : self
    {
        $this->from = $email;
        $this->fromName = $name;
        return $this;
    }

    public function addReplyTo(string $email, string $name = "") : self
    {
        $this->replyTo= $email;
        $this->replyToName = $name;
        return $this;
    }

    public function addBccTo(string $email, string $name = "") : self
    {
        $this->bccTo = $email;
        $this->bccToName = $name;
        return $this;
    }

    public function addCC(string $email, string $name = "") : self
    {
        $this->cc[] = $email;
        $this->ccName[] = $name;
        return $this;
    }

    public function addAttachment(string $path) : self
    {
        $this->attachment = $path;
        return $this;
    }

    private function compose() : void
    {
        $this->mailer = new PHPMailer(true);

        //Server settings
        $this->mailer->SMTPDebug = 0;                                 // Enable verbose debug output
        $this->mailer->isSMTP();                                      // Set mailer to use SMTP
        $this->mailer->Host = $this->mailerHost;                      // Specify main and backup SMTP servers
        $this->mailer->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mailer->Username = $this->mailerFrom;                  // SMTP username
        $this->mailer->Password = $this->mailerPassword;              // SMTP password
        //$this->mailer->SMTPSecure = $this->mailerEncryption;          // Enable TLS encryption, `ssl` also accepted
        $this->mailer->Port = 587;                                    // TCP port to connect to

        #Locaweb lixo
        $this->mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Recipients
        if (empty($this->from)) {
            $this->mailer->setFrom($this->mailerFrom);
        } else {
            $this->mailer->setFrom($this->from, $this->fromName);
        }

        foreach ($this->to as $key => $to) {
            $this->mailer->addAddress($to, $this->toName[$key] ?? '');
        }

        if (!empty($this->replyTo)) {
            $this->mailer->addReplyTo($this->replyTo, $this->replyToName);
        }

        if (!empty($this->bccTo)) {
            $this->mailer->addBCC($this->bccTo);
        }

        foreach ($this->cc as $key => $cc) {
            $this->mailer->addCC($cc, $this->ccName[$key] ?? '');
        }

        if (!empty($this->attachment)) {
            $this->mailer->addAttachment($this->attachment);
        }
    }

    public function send() : bool
    {
        try {
            $this->compose();
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $this->subject;
            $this->mailer->Body    = $this->body;
            $this->mailer->send();
            return true;
        } catch (PhpMailerException $e) {
            throw new ErrorSendingEmail($e->getMessage());
        }
    }
}