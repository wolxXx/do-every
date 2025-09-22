<?php

declare(strict_types = 1);

namespace DoEveryApp\Definition;

enum TaskType: string
{
    case CYCLIC   = 'cyclic';

    case RELATIVE = 'relative';

    case ONE_TIME = 'one-time';
}
