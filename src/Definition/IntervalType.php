<?php

declare(strict_types=1);

namespace DoEveryApp\Definition;

enum IntervalType: string
{
    case MINUTE = 'minute';

    case HOUR   = 'hour';

    case DAY    = 'day';

    case MONTH  = 'month';

    case YEAR   = 'year';
}
