<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class Worker
{
    public static function get(?\DoEveryApp\Entity\Worker $worker): string
    {
        if (null === $worker) {
            return \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->noValue();
        }

        return \DoEveryApp\Util\View\Escaper::escape(value: $worker->getName());
    }

    public static function isTimeForPasswortChange(\DoEveryApp\Entity\Worker $worker): bool
    {
        if (null === $worker->getPassword()) {
            return false;
        }
        if (null === $worker->getLastPasswordChange()) {
            return true;
        }

        return \Carbon\Carbon::now()
                             ->greaterThan(
                                 date: \Carbon\Carbon::create(year: $worker->getLastPasswordChange())
                                               ->addMonths(3),
                             )
        ;
    }
}
