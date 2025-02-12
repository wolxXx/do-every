<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Mailing;

class Login
{
    public static function send(\DoEveryApp\Entity\Worker $worker): void
    {
        $body = <<<TEXT
            Hallo {$worker->getName()}!
            
            Jemand (hoffentlich du!) hat sich gerade bei do-every* eingeloggt!
            Wenn das nicht du warst, vergebe bitte ein neues Passwort.
            
            Binäre Grüße aus dem Maschinenraum
            do-every* 
            TEXT;

        \DoEveryApp\Util\Mailer::Factory()
                               ->addRecipient($worker->getEmail(), $worker->getName())
                               ->setSubject('Neuer Login auf do-every*')
                               ->setBody(\nl2br($body))
                               ->send()
        ;
    }
}
