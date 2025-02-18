<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class FileSize
{
    public static function humanReadable(int $size): string
    {
        if (0 === $size) {
            return '0 B';
        }
        $i    = floor(num: log(num: $size, base: 1024));
        $size = round(num: $size / pow(num: 1024, exponent: $i), precision: [0, 0, 2, 2, 3][$i]);
        $size = \NumberFormatter::create(locale: \DoEveryApp\Util\User\Current::getLocale(), style: \NumberFormatter::PATTERN_DECIMAL)->format(num: $size);

        return $size . ' ' . ['B', 'kB', 'MB', 'GB', 'TB'][$i];
    }
}
