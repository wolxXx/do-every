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
        $credential = $worker->getPasswordCredential();
        if (false === $credential instanceof \DoEveryApp\Entity\Worker\Credential) {
            return false;
        }
        $passwordChangeInterval = \DoEveryApp\Util\Registry::getInstance()
                                                           ->passwordChangeInterval()
        ;
        if (0 === $passwordChangeInterval) {
            return false;
        }
        if (null === $credential->getLastPasswordChange()) {
            return true;
        }

        return \Carbon\Carbon::now()
                             ->greaterThan(
                                 date: \Carbon\Carbon::create(year: $credential->getLastPasswordChange())
                                                     ->addMonths(value: $passwordChangeInterval),
                             )
        ;
    }
}
