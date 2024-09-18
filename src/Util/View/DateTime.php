<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class DateTime
{
    public static function getDate(?\DateTime $dateTime): string
    {
        if (null === $dateTime) {
            return '-';
        }

        return '<nobr>' . \IntlDateFormatter::create(\DoEveryApp\Util\User\Current::getLocale(), \IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE)->format($dateTime) . '</nobr>';
    }


    public static function getDateTimeMediumDateMediumTime(?\DateTime $dateTime): string
    {
        if (null === $dateTime) {
            return '-';
        }

        return '<nobr>' . \IntlDateFormatter::create(\DoEveryApp\Util\User\Current::getLocale(), \IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM)->format($dateTime) . '</nobr>';
    }


    public static function getDateTimeMediumDateShortTime(?\DateTime $dateTime): string
    {
        if (null === $dateTime) {
            return '-';
        }

        return '<nobr>' . \IntlDateFormatter::create(\DoEveryApp\Util\User\Current::getLocale(), \IntlDateFormatter::RELATIVE_MEDIUM, \IntlDateFormatter::SHORT)->format($dateTime) . '</nobr>';
    }
}