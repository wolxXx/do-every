<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class ExecutionDate
{
    public static function byExecution(\DoEveryApp\Entity\Execution $execution): string
    {
        return static::byValue($execution->getDate());
    }


    public static function byValue(\DateTime $date): string
    {
        return DateTime::getDateTimeMediumDateShortTime($date);
    }
}
