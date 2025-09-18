<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Cron
{
    public function __construct()
    {
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: 'start cron object');
        if (true === Registry::getInstance()->isCronRunning()) {
            DependencyContainer::getInstance()->getLogger()->debug(message: 'Cron is already running.');

            return;
        }
        $now      = \Carbon\Carbon::now();
        $lastCron = \DoEveryApp\Util\Registry::getInstance()
                                             ->getLastCron()
        ;
        if (null !== $lastCron) {
            $lastCron = \Carbon\Carbon::create(year: $lastCron);
            $lastCron->addMinutes(5);
            if ($lastCron->gt($now)) {
                DependencyContainer::getInstance()->getLogger()->debug(message: 'Cron has no due...');

                return;
            }
        }
        Registry::getInstance()
                ->setCronRunning(cronRunning: true)
                ->setCronStarted(cronStarted: \Carbon\Carbon::now())
        ;

        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getLogger()
                                            ->debug(message: 'bar')
        ;

        echo "foo";
        echo "foo";
        echo "foo";
        echo "foo";

        \DoEveryApp\Util\Debugger::debug('asdf');

        \Amp\async(closure: function (): void {
            new \DoEveryApp\Util\Cron\Backup();
        });
        \Amp\async(closure: function (): void {
            new \DoEveryApp\Util\Cron\BackupRotation();
        });
        \Amp\async(closure: function (): void {
            new \DoEveryApp\Util\Cron\Notify();
        });

        \Revolt\EventLoop::run();

        Registry::getInstance()
                ->setLastCron(lastCron: \Carbon\Carbon::now())
        ;
        Registry::getInstance()->setCronRunning(cronRunning: false);
    }
}
