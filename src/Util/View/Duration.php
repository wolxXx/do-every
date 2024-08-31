<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class Duration
{
    public static function byExecution(\DoEveryApp\Entity\Execution $execution): string
    {
        return static::byValue($execution->getDuration());
    }


    public static function byValue(?int $duration = null): string
    {
        switch ($duration) {
            case null:
            {
                return '-';
            }
            case 1:
            {
                return 'eine Minute';
            }
            case 2:
            {
                return 'zwei Minuten';
            }
            case 3:
            {
                return 'drei Minuten';
            }
            case 4:
            {
                return 'vier Minuten';
            }
            case 5:
            {
                return 'fünf Minuten';
            }
            default:
            {
                return $duration . ' Minuten';
            }
        }
    }
}
