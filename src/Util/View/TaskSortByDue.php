<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class TaskSortByDue
{
    public static function sort($tasks): array
    {
        usort($tasks, function (\DoEveryApp\Entity\Task $a, \DoEveryApp\Entity\Task $b) {
            $dueA     = $a->getDueValue();
            $dueUnitA = $a->getDueUnit();
            $dueB     = $b->getDueValue();
            $dueUnitB = $b->getDueUnit();
            if (null === $dueA) {
                return -1;
            }
            if (null === $dueB) {
                return 1;
            }
            switch ($dueUnitA) {
                case \DoEveryApp\Definition\IntervalType::HOUR->value:
                {
                    $dueA = $dueA * 60;
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::DAY->value:
                {
                    $dueA = $dueA * 60 * 24;
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::MONTH->value:
                {
                    $dueA = $dueA * 60 * 24 * 30;
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::YEAR->value:
                {
                    $dueA = $dueA * 60 * 24 * 30 * 12;
                    break;
                }
            }
            switch ($dueUnitB) {
                case \DoEveryApp\Definition\IntervalType::HOUR->value:
                {
                    $dueB = $dueB * 60;
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::DAY->value:
                {
                    $dueB = $dueB * 60 * 24;
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::MONTH->value:
                {
                    $dueB = $dueB * 60 * 24 * 30;
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::YEAR->value:
                {
                    $dueB = $dueB * 60 * 24 * 30 * 12;
                    break;
                }
            }

            return $dueA > $dueB ? 1 : -1;
        });

        return $tasks;
    }
}
