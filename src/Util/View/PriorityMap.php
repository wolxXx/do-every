<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class PriorityMap
{
    public static function getByTask(\DoEveryApp\Entity\Task $task): string
    {
        switch ($task->getPriority()) {
            case \DoEveryApp\Definition\Priority::LOW->value:
            {
                return 'gering';
            }
            case \DoEveryApp\Definition\Priority::NORMAL->value:
            {
                return 'normal';
            }
            case \DoEveryApp\Definition\Priority::HIGH->value:
            {
                return 'hoch';
            }
            case \DoEveryApp\Definition\Priority::URGENT->value:
            {
                return 'dringend';
            }
        }
        throw new \InvalidArgumentException('??' . $task->getPriority());
    }


    public static function mapName(\DoEveryApp\Definition\Priority $priority): string
    {
        switch ($priority->name) {
            case \DoEveryApp\Definition\Priority::LOW->name:
            {
                return 'gering';
            }
            case \DoEveryApp\Definition\Priority::NORMAL->name:
            {
                return 'normal';
            }
            case \DoEveryApp\Definition\Priority::HIGH->name:
            {
                return 'hoch';
            }
            case \DoEveryApp\Definition\Priority::URGENT->name:
            {
                return 'dringend';
            }
        }
        throw new \InvalidArgumentException('??' . $priority->name);
    }
}