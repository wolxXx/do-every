<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class DisplayValue
{
    public static function do(mixed $value): string
    {
        if(\is_null($value)) {
            return '-null-';
        }
        switch (true) {
            case \is_bool($value): {
                return Boolean::get($value);
            }
            case \is_int($value): {
                return (string) $value;
            }
            case \is_a(\DateTime::class, $value):
            {
                return $value->format('Y-m-d H:i:s');
            }
            default: {
                return Escaper::escape($value);
            }
        }
    }
}
