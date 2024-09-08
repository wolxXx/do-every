<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class Escaper
{
    public static function escape(?string $value = null, ?string $nullRepresenting = ''): string
    {
        if (null === $value) {
            return $nullRepresenting;
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}