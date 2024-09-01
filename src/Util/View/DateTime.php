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

        return \IntlDateFormatter::create('de_DE', \IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE)->format($dateTime);
    }


    public static function getDateTimeMediumDateMediumTime(?\DateTime $dateTime): string
    {
        if (null === $dateTime) {
            return '-';
        }

        return \IntlDateFormatter::create('de_DE', \IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM)->format($dateTime);
    }


    public static function getDateTimeMediumDateShortTime(?\DateTime $dateTime): string
    {
        if (null === $dateTime) {
            return '-';
        }

        return \IntlDateFormatter::create('de_DE', \IntlDateFormatter::RELATIVE_MEDIUM, \IntlDateFormatter::SHORT)->format($dateTime);
    }
}