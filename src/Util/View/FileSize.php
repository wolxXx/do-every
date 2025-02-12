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
        $i    = floor(log($size, 1024));
        $size = round($size / pow(1024, $i), [0, 0, 2, 2, 3][$i]);
        $size = \NumberFormatter::create(\DoEveryApp\Util\User\Current::getLocale(), \NumberFormatter::PATTERN_DECIMAL)->format($size);

        return $size . ' ' . ['B', 'kB', 'MB', 'GB', 'TB'][$i];
    }
}
