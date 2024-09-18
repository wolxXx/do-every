<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Mailing;

class Notify
{
    /**
     * @param \DoEveryApp\Entity\Task[] $tasks
     */
    public static function send(\DoEveryApp\Entity\Worker $worker, array $tasks): void
    {
        $taskMessage = '';
        foreach ($tasks as $task) {
            $message = '';
            if (null !== $task->getGroup()) {
                $message = \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) . ': ';
            }
            $message .= \DoEveryApp\Util\View\Escaper::escape($task->getName()) . ', ';
            $message .= \DoEveryApp\Util\View\Due::getByTask($task);
            if (null !== $task->getNote()) {
                $message .= \PHP_EOL . \DoEveryApp\Util\View\Escaper::escape($task->getNote());
            }
            foreach ($task->getCheckListItems() as $checkListItem) {
                $message .= \PHP_EOL . \DoEveryApp\Util\View\Escaper::escape($checkListItem->getName());
            }
            $taskMessage .= $message . \PHP_EOL . \PHP_EOL;
        }
        $body = <<<TEXT
Hallo {$worker->getName()}!

Es stehen folgende Aufgaben an: 

{$taskMessage}

Binäre Grüße aus dem Maschinenraum
do-every* 
TEXT;

        \DoEveryApp\Util\Mailer::Factory()
                               ->addRecipient($worker->getEmail(), $worker->getName())
                               ->setSubject('Fälligkeiten von Tasks auf do-every*')
                               ->setBody(\nl2br($body))
                               ->send()
        ;
    }
}
