<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron\Notification\Item;

class TaskDue implements ItemInterface
{
    public function __construct(
        public \DoEveryApp\Entity\Task $task
    ) {
    }

    #[\Override]
    public function getContent(): string
    {
        $task = $this->task;
        $message = '';
        if (null !== $task->getGroup()) {
            $message = \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) . ': ';
        }
        $message .= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) . ', ';
        $message .= \DoEveryApp\Util\View\Due::getByTask(task: $task);
        if (null !== $task->getNote()) {
            $message .= \PHP_EOL . \DoEveryApp\Util\View\Escaper::escape(value: $task->getNote());
        }
        if (\DoEveryApp\Util\Registry::getInstance()->mailContentSteps()) {
            foreach ($task->getCheckListItems() as $checkListItem) {
                $message .= \PHP_EOL . \DoEveryApp\Util\View\Escaper::escape(value: $checkListItem->getName());
            }
        }
        return $message;
    }
}

