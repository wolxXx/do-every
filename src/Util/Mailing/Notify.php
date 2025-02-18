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
                $message = \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) . ': ';
            }
            $message .= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) . ', ';
            $message .= \DoEveryApp\Util\View\Due::getByTask(task: $task);
            if (null !== $task->getNote()) {
                $message .= \PHP_EOL . \DoEveryApp\Util\View\Escaper::escape(value: $task->getNote());
            }
            foreach ($task->getCheckListItems() as $checkListItem) {
                $message .= \PHP_EOL . \DoEveryApp\Util\View\Escaper::escape(value: $checkListItem->getName());
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
                               ->addRecipient(address: $worker->getEmail(), name: $worker->getName())
                               ->setSubject(subject: 'Fälligkeiten von Tasks auf do-every*')
                               ->setBody(body: \nl2br(string: $body))
                               ->send()
        ;
    }
}
