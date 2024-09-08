<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class DisplayValue
{
    public static function do(mixed $value): string
    {
        if (\is_null($value)) {
            return '-null-';
        }
        switch (true) {
            case \is_bool($value):
            {
                return Boolean::get($value);
            }
            case \is_int($value):
            {
                return (string)$value;
            }
            case \is_a($value, \DateTime::class):
            {
                return DateTime::getDateTimeMediumDateMediumTime($value);
            }
            default:
            {
                return Escaper::escape($value);
            }
        }
    }
}
