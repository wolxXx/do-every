<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class Due
{
    public static function getByTask(\DoEveryApp\Entity\Task $task): string
    {
        $due = $task->getDueValue();
        if ($due === 0 || $due === null) {
            return 'jetzt fällig';
        }
        if ($due > 0) {
            switch ($task->intervalType) {
                case \DoEveryApp\Definition\IntervalType::MINUTE->value:
                {
                    $unit = 1 === $due ? 'Minute' : 'Minuten';
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::HOUR->value:
                {
                    $unit = 1 === $due ? 'Stunde' : 'Stunden';
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::DAY->value:
                {
                    $unit = 1 === $due ? 'Tag' : 'Tagen';
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::MONTH->value:
                {
                    $unit = 1 === $due ? 'Monat' : 'Monaten';
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::YEAR->value:
                {
                    $unit = 1 === $due ? 'Jahr' : 'Jahren';
                    break;
                }
            }

            return 'fällig in ' . $due . ' ' . $unit;
        }
        if ($due < 1) {
            $due = abs($due);
            switch ($task->intervalType) {
                case \DoEveryApp\Definition\IntervalType::MINUTE->value:
                {
                    $unit = 1 === $due ? 'Minute' : 'Minuten';
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::HOUR->value:
                {
                    $unit = 1 === $due ? 'Stunde' : 'Stunden';
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::DAY->value:
                {
                    $unit = 1 === $due ? 'Tag' : 'Tagen';
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::MONTH->value:
                {
                    $unit = 1 === $due ? 'Monat' : 'Monaten';
                    break;
                }
                case \DoEveryApp\Definition\IntervalType::YEAR->value:
                {
                    $unit = 1 === $due ? 'Jahr' : 'Jahren';
                    break;
                }
            }

            return 'fällig seit  ' . $due . ' ' . $unit;
        }
    }

}
