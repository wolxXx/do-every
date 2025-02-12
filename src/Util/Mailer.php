<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Mailer
{
    protected \PHPMailer\PHPMailer\PHPMailer $instance;

    protected mixed                          $skipSend = false;

    protected mixed                          $mailFrom = '';

    final private function __construct()
    {
        $instance             = $this
            ->setInstance(new \PHPMailer\PHPMailer\PHPMailer(true))
            ->getInstance()
        ;
        $pathToMailConfigFile = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'mailConfiguration.php';
        if (false === \file_exists($pathToMailConfigFile)) {
            throw new \InvalidArgumentException('mail config file does not exist at ' . $pathToMailConfigFile);
        }
        $configuration  = require $pathToMailConfigFile;
        $requiredFields = [
            'skipSend',
            'host',
            'userName',
            'password',
            'port',
            'from',
            'fromName',
            'replyTo',
            'replyToName',
            'debug',
            'secure',
        ];
        if (false === is_array($configuration)) {
            throw new \Exception($pathToMailConfigFile . ' did not return an array');
        }
        foreach ($requiredFields as $requiredField) {
            if (false === array_key_exists($requiredField, $configuration)) {
                throw new \Exception('missing field "' . $requiredField . '" in ' . $pathToMailConfigFile);
            }
        }
        $mailSkipSend      = $configuration['skipSend'];
        $mailHost          = $configuration['host'];
        $mailUsername      = $configuration['userName'];
        $mailPassword      = $configuration['password'];
        $debug             = $configuration['debug'];
        $mailPort          = $configuration['port'];
        $this->mailFrom    = $configuration['from'];
        $mailFromName      = $configuration['fromName'];
        $address           = $configuration['replyTo'];
        $name              = $configuration['replyToName'];
        $mailAddBcc        = $configuration['bcc'];
        $secure            = $configuration['secure'];
        $this->skipSend    = $mailSkipSend;
        $instance->CharSet = 'UTF-8';
        $instance->isSMTP();
        $instance->Host          = $mailHost;
        $instance->Username      = $mailUsername;
        $instance->Password      = $mailPassword;
        $instance->SMTPKeepAlive = true;
        $instance->SMTPSecure    = $secure;
        $instance->SMTPAuth      = true;
        $instance->SMTPOptions   = [
            'ssl' => [
                'allow_self_signed' => true,
                'verify_peer'       => false,
                'verify_peer_name'  => false,
            ],
        ];
        $instance->Timeout       = 3;
        $instance->SMTPDebug     = 0;
        if (true === $debug) {
            $instance->SMTPDebug = 4;
        }
        $instance->Port = $mailPort;
        $instance->setLanguage('de');
        $instance->setFrom($this->mailFrom, $mailFromName);
        $instance->addReplyTo($address, $name);
        foreach ($mailAddBcc as $bcc) {
            $instance->addBCC($bcc);
        }
        $instance->isHTML(true);
        $instance->addCustomHeader('foo', 'bar');
        $instance->addCustomHeader('bar', 'foo');
    }

    protected function getInstance(): \PHPMailer\PHPMailer\PHPMailer
    {
        return $this->instance;
    }

    protected function setInstance(\PHPMailer\PHPMailer\PHPMailer $mailer): static
    {
        $this->instance = $mailer;

        return $this;
    }

    public static function Factory(): static
    {
        return new static();
    }

    public function send(): bool
    {
        $directoryName = \ROOT_DIR . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'mail' . DIRECTORY_SEPARATOR;
        if (false === is_dir($directoryName)) {
            mkdir($directoryName, 0777, true);
        }
        file_put_contents($directoryName . (new \DateTime())->format('Y-m-d_H:i:s') . uniqid() . '.html', $this->getInstance()->Body);
        if (true === $this->skipSend) {
            return true;
        }
        set_time_limit(10);
        $result = $this->getInstance()->send();
        if (false === $result) {
            throw new \Exception($this->getInstance()->ErrorInfo);
        }

        return true;
    }

    public function setSubject(string $subject): static
    {
        $this->getInstance()->Subject = $subject;

        return $this;
    }

    public function addRecipient(string $address, ?string $name = null): static
    {
        $this->getInstance()->addAddress($address, $name);

        return $this;
    }

    public function addCc(string $address, ?string $name = null): static
    {
        $this->getInstance()->addCC($address, $name);

        return $this;
    }

    public function addBcc(string $address, ?string $name = null): static
    {
        $this->getInstance()->addBCC($address, $name);

        return $this;
    }

    public function setHtml(string $html): static
    {
        $this
            ->getInstance()
            ->msgHTML($html)
        ;

        return $this;
    }

    public function setBody(string $body): static
    {
        $this->getInstance()->Body = $body;

        return $this;
    }

    public function setAlternativeBody(string $body): static
    {
        $this->getInstance()->AltBody = $body;

        return $this;
    }

    public function isSkipSend(): bool
    {
        return $this->skipSend;
    }

    public function getMailFrom(): string
    {
        return $this->mailFrom;
    }
}
