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

Binäre Grüße aus dem Maschinenraum
do-every* 
TEXT;

        \DoEveryApp\Util\Mailer::Factory()
                               ->addRecipient($worker->getEmail(), $worker->getName())
                               ->setSubject('Neues Passwort gesetzt auf do-every*')
                               ->setBody($body)
                               ->send()
        ;
    }
}
