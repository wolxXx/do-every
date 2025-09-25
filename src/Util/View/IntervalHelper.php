<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class IntervalHelper
{
    public static function getTypeByTask(\DoEveryApp\Entity\Task $task): string
    {
        return static::getType($task->getType());
    }

    public static function getTypeByTaskString(string $taskType): string
    {
        return static::getType(\DoEveryApp\Definition\TaskType::from(value: $taskType));
    }

    public static function getType(\DoEveryApp\Definition\TaskType $type): string
    {
        return match($type->value) {
            \DoEveryApp\Definition\TaskType::CYCLIC->value => \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->intervalTypeCyclic(),
            \DoEveryApp\Definition\TaskType::RELATIVE->value => \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->intervalTypeRelative(),
            \DoEveryApp\Definition\TaskType::ONE_TIME->value => \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->intervalTypeOneTime(),
        };
    }

    public static function get(\DoEveryApp\Entity\Task $task): string
    {
        $translator = \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator();
        if (null === $task->getIntervalType()) {
            return $translator->noValue();
        }
        $intervalValue = $task->getIntervalValue();
        $isPlural      = $intervalValue !== 1;
        switch ($task->getIntervalType()) {
            case \DoEveryApp\Definition\IntervalType::MINUTE->value:
            {
                return $isPlural ? $translator->dueIsEvery() . ' ' . $intervalValue . ' ' . $translator->minutes() : $translator->dueIsEveryMinute();
            }
            case \DoEveryApp\Definition\IntervalType::HOUR->value:
            {
                return $isPlural ? $translator->dueIsEvery() . ' ' . $intervalValue . ' ' . $translator->hours() : $translator->dueIsEveryHour();
            }
            case \DoEveryApp\Definition\IntervalType::DAY->value:
            {
                return $isPlural ? $translator->dueIsEvery() . ' ' . $intervalValue . ' ' . $translator->days() : $translator->dueIsEveryDay();
            }
            case \DoEveryApp\Definition\IntervalType::MONTH->value:
            {
                return $isPlural ? $translator->dueIsEvery() . ' ' . $intervalValue . ' ' . $translator->months() : $translator->dueIsEveryMonth();
            }
            case \DoEveryApp\Definition\IntervalType::YEAR->value:
            {
                return $isPlural ? $translator->dueIsEvery() . ' ' . $intervalValue . ' ' . $translator->years() : $translator->dueIsEveryYear();
            }
        }
        throw new \InvalidArgumentException(message: '??' . $task->getIntervalType() . $task->getIntervalValue());
    }

    public static function map(\DoEveryApp\Definition\IntervalType $intervalType): string
    {
        switch ($intervalType->name) {
            case \DoEveryApp\Definition\IntervalType::MINUTE->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->minute();
            }
            case \DoEveryApp\Definition\IntervalType::HOUR->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->hour();
            }
            case \DoEveryApp\Definition\IntervalType::DAY->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->day();
            }
            case \DoEveryApp\Definition\IntervalType::MONTH->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->month();
            }
            case \DoEveryApp\Definition\IntervalType::YEAR->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->year();
            }
            default:
            {
                throw new \InvalidArgumentException(message: '??' . $intervalType->name);
            }
        }
    }
}
