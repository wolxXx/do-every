<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class TaskNote
{
    public static function byTask(\DoEveryApp\Entity\Task $task): string
    {
        return static::byValue($task->getNote());
    }

    public static function byValue(?string $note = null): string
    {
        if (null === $note) {
            return '';
        }

        $note       = nl2br(\DoEveryApp\Util\View\Escaper::escape($note));
        $noteLegend = \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->notice();

        return '<fieldset class="taskNote"><legend>' . $noteLegend . '</legend>' . $note . '</fieldset>';
    }
}
