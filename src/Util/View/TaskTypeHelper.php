<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class TaskTypeHelper
{
    public static function map(\DoEveryApp\Definition\IntervalType $intervalType): string
    {
        switch ($intervalType->name) {
            case \DoEveryApp\Definition\IntervalType::MINUTE->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->minute();
            }
            case \DoEveryApp\Definition\IntervalType::HOUR->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->hour();
            }
            case \DoEveryApp\Definition\IntervalType::DAY->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->day();
            }
            case \DoEveryApp\Definition\IntervalType::MONTH->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->month();
            }
            case \DoEveryApp\Definition\IntervalType::YEAR->name:
            {
                return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->year();
            }
            default:
            {
                throw new \InvalidArgumentException(message: '??' . $intervalType->name);
            }
        }
    }
}
