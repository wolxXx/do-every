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
        $numberFormatter = \NumberFormatter::create('de_DE', \NumberFormatter::PATTERN_DECIMAL);

        $seitIn = 'in';
        if ($due < 0) {
            $seitIn = 'seit';
            $due    = abs($due);
        }
        $due = $numberFormatter->format(\round($due, \DoEveryApp\Util\Registry::getInstance()->getPrecisionDue()));

        switch ($task->getDueUnit()) {
            case \DoEveryApp\Definition\IntervalType::MINUTE->value:
            {
                $unit = '1' === $due ? 'Minute' : 'Minuten';
                break;
            }
            case \DoEveryApp\Definition\IntervalType::HOUR->value:
            {
                $unit = '1' === $due ? 'Stunde' : 'Stunden';
                break;
            }
            case \DoEveryApp\Definition\IntervalType::DAY->value:
            {
                $unit = '1' === $due ? 'Tag' : 'Tagen';
                break;
            }
            case \DoEveryApp\Definition\IntervalType::MONTH->value:
            {
                $unit = '1' === $due ? 'Monat' : 'Monaten';
                break;
            }
            case \DoEveryApp\Definition\IntervalType::YEAR->value:
            {
                $unit = '1' === $due ? 'Jahr' : 'Jahren';
                break;
            }
        }

        return 'fällig ' . $seitIn . ' ' . $due . ' ' . $unit;
    }

}
