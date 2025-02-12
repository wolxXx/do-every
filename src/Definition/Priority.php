<?php

declare(strict_types=1);

namespace DoEveryApp\Definition;

enum Priority: int
{
    case LOW    = 50;

    case NORMAL = 100;

    case HIGH   = 150;

    case URGENT = 200;
}
