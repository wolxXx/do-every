<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Mailing;

class CronHanging
{
    public static function send(): void
    {
        $hostname = gethostname();
        if (false === $hostname) {
            $hostname = 'unknown machine';
        }
        $lastRun     = \DoEveryApp\Util\Registry::getInstance()
                                                ->getLastCron()
                                                ?->format('Y-m-d H:i:s') ?: 'unknown';
        $cronStarted = \DoEveryApp\Util\Registry::getInstance()
                                                ->getCronStarted()
                                                ?->format('Y-m-d H:i:s') ?: 'unknown';
        $body = <<<TEXT
            Hallo !
            
            Der Cronjob auf dem Server $hostname läuft nicht mehr.
            
            Letzter Cronjob: $lastRun
            
            Cronjob gestartet: $cronStarted
            
            Resette jetzt die Werte.
            
            Binäre Grüße aus dem Maschinenraum
            do-every* 
            TEXT;

        \DoEveryApp\Util\Mailer::Factory()
                               ->setSubject(subject: 'Cronjob hängt auf do-every* Instanz ' . $hostname)
                               ->setBody(body: \nl2br(string: $body))
                               ->send()
        ;
    }
}
