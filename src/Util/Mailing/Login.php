<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Mailing;

class Login
{
    public static function send(\DoEveryApp\Entity\Worker $worker, string $method): void
    {
        $body = <<<TEXT
            Hallo {$worker->getName()}!
            
            Jemand (hoffentlich du!) hat sich gerade bei do-every* eingeloggt!
            Wenn das nicht du warst, vergebe bitte ein neues Passwort.
            
            Es wurde folgende Login-Methode verwendet: {$method}
            
            Binäre Grüße aus dem Maschinenraum
            do-every* 
            TEXT;

        \DoEveryApp\Util\Mailer::Factory()
                               ->addRecipient(address: $worker->getEmail(), name: $worker->getName())
                               ->setSubject(subject: 'Neuer Login auf do-every*')
                               ->setBody(body: \nl2br(string: $body))
                               ->send()
        ;
    }
}
