<?php


declare(strict_types=1);

namespace DoEveryApp\Definition;


enum Priority: int
{
    case LOW    = 0;

    case NORMAL = 100;

    case HIGH   = 200;

    case URGENT = 300;
}