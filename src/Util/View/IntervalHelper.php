<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class IntervalHelper
{
    public static function get(\DoEveryApp\Entity\Task $task): string
    {
        if (null === $task->getIntervalType()) {
            return '-';
        }
        $intervalValue = $task->getIntervalValue();
        $isPlural      = $intervalValue !== 1;
        switch ($task->getIntervalType()) {
            case \DoEveryApp\Definition\IntervalType::MINUTE->value:
            {
                return $isPlural ? 'alle ' . $intervalValue . ' Minuten' : ' jede Minute';
            }
            case \DoEveryApp\Definition\IntervalType::HOUR->value:
            {
                return $isPlural ? 'alle ' . $intervalValue . ' Stunden' : ' jede Stunde';
            }
            case \DoEveryApp\Definition\IntervalType::DAY->value:
            {
                return $isPlural ? 'alle ' . $intervalValue . ' Tage' : ' jeden Tag';
            }
            case \DoEveryApp\Definition\IntervalType::MONTH->value:
            {
                return $isPlural ? 'alle ' . $intervalValue . ' Monate' : ' jeden Monat';
            }
            case \DoEveryApp\Definition\IntervalType::YEAR->value:
            {
                return $isPlural ? 'alle ' . $intervalValue . ' Jahre' : ' jedes Jahr';
            }
        }
        throw new \InvalidArgumentException('??' . $task->getIntervalType() . $task->getIntervalValue());
    }
}