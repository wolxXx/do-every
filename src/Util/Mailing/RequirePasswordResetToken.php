<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Mailing;

class RequirePasswordResetToken
{
    public static function send(\DoEveryApp\Entity\Worker $worker): void
    {
        $body = <<<TEXT
Hallo {$worker->getName()}!
 
Jemand (hoffentlich du!) hat ein neues Passwort für do-every* angefordert.
Gib diesen Code ein, um ein neues Passwort zu setzen: {$worker->getPasswordResetToken()}
Dieser Code ist gültig bis zum {$worker->getTokenValidUntil()->format('d.m.Y, H:i')}

Binäre Grüße aus dem Maschinenraum
do-every* 
TEXT;

        \DoEveryApp\Util\Mailer::Factory()
                               ->addRecipient($worker->getEmail(), $worker->getName())
                               ->setSubject('Passwort verloren auf do-every*')
                               ->setBody(\nl2br($body))
                               ->send()
        ;
    }
}
