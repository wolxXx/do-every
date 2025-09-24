<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Mailing;

class Notify
{
    /**
     * @param \DoEveryApp\Entity\Task[] $tasks
     */
    public static function send(\DoEveryApp\Util\Cron\Notification\Container $container): void
    {
        $taskMessage = '';
        foreach ($container->getItems() as $task) {
            $taskMessage .= $task->getContent() . \PHP_EOL . \PHP_EOL;
        }
        $body = <<<TEXT
            Hallo {$container->worker->getName()}!
            
            Es stehen folgende Aufgaben an: 
            
            {$taskMessage}
            
            Binäre Grüße aus dem Maschinenraum
            do-every* 
            TEXT;

        \DoEveryApp\Util\Mailer::Factory()
                               ->addRecipient(address: $container->worker->getEmail(), name: $container->worker->getName())
                               ->setSubject(subject: 'Fälligkeiten von Tasks auf do-every*')
                               ->setBody(body: \nl2br(string: $body))
                               ->send()
        ;
    }
}
