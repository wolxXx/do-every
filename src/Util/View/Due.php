<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class Due
{
    public static function getByTask(\DoEveryApp\Entity\Task $task): string
    {
        $translator = \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator();
        $due        = $task->getDueValue();
        if ($due === 0 || $due === null) {
            return $translator->dueIsNow();
        }
        $numberFormatter = \NumberFormatter::create(\DoEveryApp\Util\User\Current::getLocale(), \NumberFormatter::PATTERN_DECIMAL);

        $sinceInSwitch = $translator->dueIsInFuture();
        if ($due < 0) {
            $sinceInSwitch = $translator->dueIsInPast();
            $due           = abs($due);
        }
        $due = $numberFormatter->format(\round($due, \DoEveryApp\Util\Registry::getInstance()->getPrecisionDue()));

        switch ($task->getDueUnit()) {
            case \DoEveryApp\Definition\IntervalType::MINUTE->value:
            {
                $unit = '1' === $due ? $translator->minute() : $translator->minutes();
                break;
            }
            case \DoEveryApp\Definition\IntervalType::HOUR->value:
            {
                $unit = '1' === $due ? $translator->hour() : $translator->hours();
                break;
            }
            case \DoEveryApp\Definition\IntervalType::DAY->value:
            {
                $unit = '1' === $due ? $translator->day() : $translator->days();
                break;
            }
            case \DoEveryApp\Definition\IntervalType::MONTH->value:
            {
                $unit = '1' === $due ? $translator->month() : $translator->months();
                break;
            }
            case \DoEveryApp\Definition\IntervalType::YEAR->value:
            {
                $unit = '1' === $due ? $translator->year() : $translator->years();
                break;
            }
            default:
            {
                throw new \InvalidArgumentException('??' . $task->getDueUnit());
            }
        }

        return $translator->dueAdverb() . ' ' . $sinceInSwitch . ' ' . $due . ' ' . $unit;
    }
}
