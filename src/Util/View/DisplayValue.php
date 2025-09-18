<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class DisplayValue
{
    public static function do(mixed $value): string
    {
        switch (true) {
            case \is_null(value: $value):
            {
                return '-null-';
            }
            case \is_bool(value: $value):
            {
                return Boolean::get(value: $value);
            }
            case \is_int(value: $value):
            {
                return (string)$value;
            }
            case \is_float(value: $value):
            {
                return \NumberFormatter::create(locale: \DoEveryApp\Util\User\Current::getLocale(), style: \NumberFormatter::PATTERN_DECIMAL)->format(num: $value);
            }
            case \is_a(object_or_class: $value, class: \DateTime::class):
            {
                return DateTime::getDateTimeMediumDateMediumTime(dateTime: $value);
            }
            default:
            {
                return Escaper::escape(value: $value);
            }
        }
    }
}
