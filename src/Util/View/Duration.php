<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class Duration
{
    public static function byExecution(\DoEveryApp\Entity\Execution $execution): string
    {
        return static::byValue($execution->getDuration());
    }


    public static function byValue(?int $duration = null): string
    {
        switch ($duration) {
            case null:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->noValue();
            }
            case 1:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->oneMinute();
            }
            case 2:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->twoMinutes();
            }
            case 3:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->threeMinutes();
            }
            case 4:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->fourMinutes();
            }
            case 5:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->fiveMinutes();
            }
            default:
            {
                return $duration . ' ' . \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->minutes();
            }
        }
    }
}
