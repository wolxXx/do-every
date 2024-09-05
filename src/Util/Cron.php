<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Cron
{
    public function __construct()
    {
        $now      = \Carbon\Carbon::now();
        $lastCron = \DoEveryApp\Util\Registry::getInstance()
                                             ->getLastCron()
        ;
        if (null !== $lastCron) {
            $lastCron = \Carbon\Carbon::create($lastCron);
            $lastCron->addMinutes(10);
            if ($lastCron->lt($now)) {
                return;
            }
        }

        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getLogger()
                                            ->debug('bar')
        ;

        echo "foo";
        echo "foo";
        echo "foo";
        echo "foo";

        \DoEveryApp\Util\Debugger::debug('asdf');
        Registry::getInstance()
                ->setLastCron(\Carbon\Carbon::now())
        ;
    }
}