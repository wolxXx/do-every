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

        return '<nobr>' . \IntlDateFormatter::create(locale: \DoEveryApp\Util\User\Current::getLocale(), dateType: \IntlDateFormatter::MEDIUM, timeType: \IntlDateFormatter::NONE)->format($dateTime) . '</nobr>';
    }

    public static function getDateTimeMediumDateMediumTime(?\DateTime $dateTime, ?string $emptyValue = null): string
    {
        if (null === $dateTime) {
            return $emptyValue ??'-';
        }

        return '<nobr>' . \IntlDateFormatter::create(locale: \DoEveryApp\Util\User\Current::getLocale(), dateType: \IntlDateFormatter::MEDIUM, timeType: \IntlDateFormatter::MEDIUM)->format($dateTime) . '</nobr>';
    }

    public static function getDateTimeMediumDateShortTime(?\DateTime $dateTime): string
    {
        if (null === $dateTime) {
            return '-';
        }

        return '<nobr>' . \IntlDateFormatter::create(locale: \DoEveryApp\Util\User\Current::getLocale(), dateType: \IntlDateFormatter::RELATIVE_MEDIUM, timeType: \IntlDateFormatter::SHORT)->format($dateTime) . '</nobr>';
    }
}
