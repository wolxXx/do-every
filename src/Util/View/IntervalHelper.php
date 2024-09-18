<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class IntervalHelper
{

    public static function getElapsingTypeByTask(\DoEveryApp\Entity\Task $task): string
    {
        return static::getElapsingTypeByBoolean($task->isElapsingCronType());
    }


    public static function getElapsingTypeByBoolean(bool $elapsing): string
    {
        $translator = \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator();
        if (true === $elapsing) {
            return $translator->intervalTypeRelative();
        }

        return $translator->intervalTypeCyclic();
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
        throw new \InvalidArgumentException('??' . $task->getIntervalType() . $task->getIntervalValue());
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
                throw new \InvalidArgumentException('??' . $intervalType->name);
            }
        }
    }
}