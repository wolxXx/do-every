<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class PriorityMap
{
    public static function getByTask(\DoEveryApp\Entity\Task $task): string
    {
        return static::mapName(\DoEveryApp\Definition\Priority::from($task->getPriority()));
    }


    public static function mapName(\DoEveryApp\Definition\Priority $priority): string
    {
        switch ($priority->name) {
            case \DoEveryApp\Definition\Priority::LOW->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->priorityLow();
            }
            case \DoEveryApp\Definition\Priority::NORMAL->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->priorityNormal();
            }
            case \DoEveryApp\Definition\Priority::HIGH->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->priorityHigh();
            }
            case \DoEveryApp\Definition\Priority::URGENT->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->priorityUrgent();
            }
        }
        throw new \InvalidArgumentException('??' . $priority->name);
    }
}