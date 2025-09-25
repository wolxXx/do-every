<?php

declare(strict_types = 1);

namespace DoEveryApp\Util\View;

class Worker
{
    public static function get(?\DoEveryApp\Entity\Worker $worker): string
    {
        if (null === $worker) {
            return \DoEveryApp\Util\DependencyContainer::getInstance()
                                                       ->getTranslator()
                                                       ->noValue()
            ;
        }

        return \DoEveryApp\Util\View\Escaper::escape(value: $worker->getName());
    }

    public static function isTimeForPasswordChange(\DoEveryApp\Entity\Worker $worker): bool
    {
        if (null === $worker->getPassword()) {
            return false;
        }
        $passwordChangeInterval = \DoEveryApp\Util\Registry::getInstance()
                                                           ->passwordChangeInterval()
        ;
        if (0 === $passwordChangeInterval) {
            return false;
        }
        if (null === $worker->getLastPasswordChange()) {
            return true;
        }

        return \Carbon\Carbon::now()
                             ->greaterThan(
                                 date: \Carbon\Carbon::create(year: $worker->getLastPasswordChange())
                                                     ->addMonths(value: $passwordChangeInterval),
                             )
        ;
    }
}
