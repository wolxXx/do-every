<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Cron
{
    public function __construct()
    {
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug('start cron object');
        if (true === Registry::getInstance()->isCronRunning()) {
            DependencyContainer::getInstance()->getLogger()->debug('Cron is already running.');

            return;
        }
        $now      = \Carbon\Carbon::now();
        $lastCron = \DoEveryApp\Util\Registry::getInstance()
                                             ->getLastCron()
        ;
        if (null !== $lastCron) {
            $lastCron = \Carbon\Carbon::create($lastCron);
            $lastCron->addMinutes(5);
            if ($lastCron->gt($now)) {
                DependencyContainer::getInstance()->getLogger()->debug('Cron has no due...');

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

        \Amp\async(function (): void {
            new \DoEveryApp\Util\Cron\Backup();
        });
        \Amp\async(function (): void {
            new \DoEveryApp\Util\Cron\BackupRotation();
        });
        \Amp\async(function (): void {
            new \DoEveryApp\Util\Cron\Notify();
        });

        \Revolt\EventLoop::run();

        Registry::getInstance()
                ->setLastCron(\Carbon\Carbon::now())
        ;
        Registry::getInstance()->setCronRunning(false);
    }
}
