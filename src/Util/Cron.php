<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Cron
{
    public function __construct()
    {
        if (true === Registry::getInstance()->isCronRunning()) {
            return;
        }
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
        Registry::getInstance()
                ->setCronRunning(true)
                ->setCronStarted(\Carbon\Carbon::now())
        ;

        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getLogger()
                                            ->debug('bar')
        ;

        echo "foo";
        echo "foo";
        echo "foo";
        echo "foo";

        \DoEveryApp\Util\Debugger::debug('asdf');

        \Amp\async(function () {
            new \DoEveryApp\Util\Cron\Backup();
        });

        \Revolt\EventLoop::run();


        Registry::getInstance()
                ->setLastCron(\Carbon\Carbon::now())
        ;
        Registry::getInstance()->setCronRunning(false);
    }
}