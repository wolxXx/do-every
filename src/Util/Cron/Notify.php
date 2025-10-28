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
        $now             = \Carbon\Carbon::now();
        $registry        = \DoEveryApp\Util\Registry::getInstance();
        $entityManager   = \DoEveryApp\Util\DependencyContainer::getInstance()->getEntityManager();
        $notifierLastRun = $registry->getNotifierLastRun();
        $force           = false;
        $lastCron        = \Carbon\Carbon::create(year: $notifierLastRun);
        $lastCron->addHours(23);
        if ($lastCron->gt($now)) {
            $force = true;
        }

        if (true === $registry->isNotifierRunning()) {
            if (true !== $force) {
                return;
            }
        }
        $registry->setNotifierRunning(notifierRunning: true);
        $entityManager->flush();

        $workers = \DoEveryApp\Entity\Worker::getRepository()->findAll();
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
        if (true === $registry->mailContentSecurityNote()) {
            foreach ($workers as $worker) {
                $container                          = new \DoEveryApp\Util\Cron\Notification\Container(worker: $worker);
                $this->containers[$worker->getId()] = $container;
                if (true === \DoEveryApp\Util\View\Worker::isTimeForPasswordChange(worker: $worker)) {
                    $this->containers[$worker->getId()]->addItem(new \DoEveryApp\Util\Cron\Notification\Item\PasswordChange(lastChange: $worker->getLastPasswordChange()));
                }
                if (null !== $worker->getPasswordCredential() && null === $worker->getTwoFactorSecret()) {
                    $this->containers[$worker->getId()]->addItem(new \DoEveryApp\Util\Cron\Notification\Item\TwoFactorAdd());
                }
            }
        }
        $tasks = \DoEveryApp\Entity\Task::getRepository()->findAll();
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

            return true === \in_array(
                needle: $task->getDueUnit(),
                haystack: [
                    \DoEveryApp\Definition\IntervalType::HOUR->value,
                    \DoEveryApp\Definition\IntervalType::MINUTE->value,
                ]
            );
        });

        foreach (\DoEveryApp\Util\View\TaskSortByDue::sort(tasks: $tasks) as $task) {
            foreach ($this->containers as $container) {
                $container->addItem(item: new \DoEveryApp\Util\Cron\Notification\Item\TaskDue(task: $task));
            }
        }
        $this->notify();
        $registry
            ->setNotifierRunning(notifierRunning: false)
            ->setNotifierLastRun(notifierLastRun: \Carbon\Carbon::now())
        ;
        $entityManager->flush();
    }

    public function notify(): void
    {
        foreach ($this->containers as $container) {
            if (0 === $container->itemCount()) {
                continue;
            }
            try {
                \DoEveryApp\Util\Mailing\Notify::send(container: $container);
                foreach ($container->getItems() as $item) {
                    if (false === $item instanceof \DoEveryApp\Util\Cron\Notification\Item\TaskDue) {
                        continue;
                    }
                    $notification = new \DoEveryApp\Entity\Notification()
                        ->setWorker(worker: $container->worker)
                        ->setTask(task: $item->task)
                        ->setDate(date: \Carbon\Carbon::now())
                    ;
                    $notification::getRepository()->create(entity: $notification);
                }

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
