<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Mailing;

class PasswordChanged
{
    public static function send(\DoEveryApp\Entity\Worker $worker): void
    {
        $body = <<<TEXT
            Hallo {$worker->getName()}!
            
            Jemand (hoffentlich du!) hat ein neues Passwort für do-every* gesetzt.
            Wenn das nicht du warst, vergebe bitte ein neues Passwort.
            
            Alle deine Zugangsdaten wurden gelöscht: Passkey und Passwort.
            
            Binäre Grüße aus dem Maschinenraum
            do-every* 
            TEXT;

        \DoEveryApp\Util\Mailer::Factory()
                               ->addRecipient(address: $worker->getEmail(), name: $worker->getName())
                               ->setSubject(subject: 'Neues Passwort gesetzt auf do-every*')
                               ->setBody(body: \nl2br(string: $body))
                               ->send()
        ;
    }
}
