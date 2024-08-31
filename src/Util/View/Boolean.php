<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class Boolean
{
    public static function get(bool $value): string
    {
        return true === $value ? 'ja' : 'nein';
    }
}
