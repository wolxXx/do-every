<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class TaskSortByDue
{
    /**
     * @return \DoEveryApp\Entity\Task[]
     */
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
            $foo  = function (float|int $a, string $b): int|float {
                switch ($b) {
                    case \DoEveryApp\Definition\IntervalType::HOUR->value:
                    {
                        return $a * 60;
                    }
                    case \DoEveryApp\Definition\IntervalType::DAY->value:
                    {
                        return $a * 60 * 24;
                    }
                    case \DoEveryApp\Definition\IntervalType::MONTH->value:
                    {
                        return $a * 60 * 24 * 30;
                    }
                    case \DoEveryApp\Definition\IntervalType::YEAR->value:
                    {
                        return $a * 60 * 24 * 30 * 12;
                    }
                    default: return $a;
                }
            };
            $dueA = $foo($dueA, $dueUnitA);
            $dueB = $foo($dueB, $dueUnitB);

            return $dueA > $dueB ? 1 : -1;
        });

        return $tasks;
    }
}
