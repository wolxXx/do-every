<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

use Carbon\Carbon;

class Cron
{
    public function __construct()
    {
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: 'cron running: ' . (true === Registry::getInstance()->isCronRunning() ? 'true' : 'false'));
        if (true === Registry::getInstance()->isCronRunning()) {
            if (null !== Registry::getInstance()->getCronStarted() && \Carbon\Carbon::instance(Registry::getInstance()->getCronStarted())->addMinutes(value: 30)->lt(Carbon::now())) {
                try {
                    Mailing\CronHanging::send();
                } catch (\Throwable) {

                }
                Registry::getInstance()
                    ->setCronRunning(cronRunning: false)
                    ->setNotifierRunning(notifierRunning: false);
            }
        }
        $now = \Carbon\Carbon::now();
        $lastCron = \DoEveryApp\Util\Registry::getInstance()
            ->getLastCron();
        if (null !== $lastCron) {
            $lastCron = \Carbon\Carbon::create(year: $lastCron);
            $lastCron->addMinutes(5);
            if ($lastCron->gt($now)) {

                DependencyContainer::getInstance()->getLogger()->debug(message: 'cron has no due');
                return;
            }
        }
        DependencyContainer::getInstance()->getLogger()->debug(message: 'Cron started');
        Registry::getInstance()
            ->setCronRunning(cronRunning: true)
            ->setCronStarted(cronStarted: \Carbon\Carbon::now());
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: 'launching notifier cron');
        new \DoEveryApp\Util\Cron\Notify();
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: 'launching backup cron');
        new \DoEveryApp\Util\Cron\Backup();
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: 'launching backup rotation cron');
        new \DoEveryApp\Util\Cron\BackupRotation();

        DependencyContainer::getInstance()
            ->getLogger()
            ->debug(message: 'Cron finished');;

        Registry::getInstance()
            ->setLastCron(lastCron: \Carbon\Carbon::now())
            ->setCronRunning(cronRunning: false);
    }
}
