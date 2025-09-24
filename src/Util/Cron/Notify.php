<?php

declare(strict_types = 1);

namespace DoEveryApp\Util\Cron;

class Notify
{
    /**
     * @var \DoEveryApp\Util\Cron\Notification\Container[]
     */
    public array $containers = [];

    public function __construct()
    {
        $now = \Carbon\Carbon::now();
        $notifierLastRun = \DoEveryApp\Util\Registry::getInstance()
                                                    ->getNotifierLastRun()
        ;
        $force = false;
        $lastCron = \Carbon\Carbon::create(year: $notifierLastRun);
        $lastCron->addHours(23);
        if ($lastCron->gt($now)) {
            $force = true;
        }

        if (
            true === \DoEveryApp\Util\Registry::getInstance()
                                              ->isNotifierRunning()
        ) {
            if (true !== $force) {
                return;
            }
        }

        \DoEveryApp\Util\Registry::getInstance()
                                 ->setNotifierRunning(notifierRunning: true)
        ;
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;

        $workers = \DoEveryApp\Entity\Worker::getRepository()
                                            ->findAll()
        ;
        $workers = \array_filter(array: $workers, callback: function(\DoEveryApp\Entity\Worker $worker) use ($now) {
            if (null === $worker->getEmail() || false === $worker->doNotify()) {
                return false;
            }
            $lastNotification = \DoEveryApp\Entity\Notification::getRepository()
                                                               ->getLastForWorker(worker: $worker)
            ;
            if (null === $lastNotification) {
                return true;
            }
            $notificationDate = $lastNotification->getDate();
            $date             = \Carbon\Carbon::create(year: $notificationDate);
            $diff             = $date->diff(date: $now, absolute: true, skip: [
                'y',
                'm',
            ]);

            return $diff->d > 0 || $diff->h > 22;
        });

        foreach ($workers as $worker) {
            $this->containers[$worker->getId()] = new \DoEveryApp\Util\Cron\Notification\Container(worker: $worker);
            if (true === \DoEveryApp\Util\View\Worker::isTimeForPasswordChange(worker: $worker)) {
                $this->containers[$worker->getId()]->addItem(new \DoEveryApp\Util\Cron\Notification\Item\PasswordChange(lastChange: $worker->getLastPasswordChange()));
            }
        }

        $tasks = \DoEveryApp\Entity\Task::getRepository()
                                        ->findAll()
        ;
        $tasks = \array_filter(array: $tasks, callback: function(\DoEveryApp\Entity\Task $task) {
            if (false === $task->isActive()) {
                return false;
            }
            if (false === $task->isNotify()) {
                return false;
            }
            if (null === $task->getDueValue()) {
                return true;
            }
            if ($task->getDueValue() < 0) {
                return true;
            }

            return true === \in_array(needle: $task->getDueUnit(), haystack: [
                    \DoEveryApp\Definition\IntervalType::HOUR->value,
                    \DoEveryApp\Definition\IntervalType::MINUTE->value,
                ]);
        });

        foreach (\DoEveryApp\Util\View\TaskSortByDue::sort(tasks: $tasks) as $task) {
            foreach ($this->containers as $container) {
                $container->addItem(item: new \DoEveryApp\Util\Cron\Notification\Item\TaskDue(task: $task));
            }
        }
        $this->notify();
        \DoEveryApp\Util\Registry::getInstance()
                                 ->setNotifierRunning(notifierRunning: false)
                                 ->setNotifierLastRun(notifierLastRun: \Carbon\Carbon::now())
        ;
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
    }

    public function notify(): void
    {
        foreach ($this->containers as $container) {
            if (0 === $container->count()) {
                continue;
            }
            try {
                \DoEveryApp\Util\Mailing\Notify::send(container: $container);
            } catch (\Throwable $exception) {
                \DoEveryApp\Util\DependencyContainer::getInstance()
                                                    ->getLogger()
                                                    ->error(message: 'notification mail failed. ' . $exception->getMessage() . \PHP_EOL . \PHP_EOL . $exception->getTraceAsString())
                ;
            }

        }

        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
    }
}
