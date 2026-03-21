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
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: 'cron notifier started');
        $now             = \Carbon\Carbon::now();
        $registry        = \DoEveryApp\Util\Registry::getInstance();
        $entityManager   = \DoEveryApp\Util\DependencyContainer::getInstance()->getEntityManager();
        $notifierLastRun = $registry->getNotifierLastRun();
        $force           = false;
        $lastCron        = \Carbon\Carbon::create(year: $notifierLastRun);
        $lastCron->addHours(23);
        if ($lastCron->gt($now)) {
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': setting force to true');
            $force = true;
        }

        if (true === $registry->isNotifierRunning()) {
            if (true !== $force) {
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': notifier running, skipping');
                return;
            }
        }
        $registry->setNotifierRunning(notifierRunning: true);
        $entityManager->flush();

        $workers = \DoEveryApp\Entity\Worker::getRepository()->findAll();
        foreach ($workers as $worker) {
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': checking worker: ' . $worker->getId());
        }
        $workers = \array_filter(array: $workers, callback: function(\DoEveryApp\Entity\Worker $worker) use ($now) {
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': filtering worker: ' . $worker->getId());
            if (null === $worker->getEmail() || false === $worker->doNotify()) {
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': skipping worker: ' . $worker->getId());
                return false;
            }
            $lastNotification = \DoEveryApp\Entity\Notification::getRepository()
                                                               ->getLastForWorker(worker: $worker)
            ;
            if (null === $lastNotification) {
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': using worker: ' . $worker->getId());
                return true;
            }
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': checking worker: ' . $worker->getId());
            $notificationDate = $lastNotification->getDate();
            $date             = \Carbon\Carbon::create(year: $notificationDate);
            $diff             = $date->diff(date: $now, absolute: true, skip: [
                'y',
                'm',
            ]);
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': checking worker: ' . $worker->getId());
            $use = $diff->d > 0 || $diff->h > 22;
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': using worker: ' . $worker->getId() . ': ' . ($use ? 'true' : 'false'));

            return $use;
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
        foreach ($tasks as $task) {
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': checking task: ' . $task->getId());
        }
        $tasks = \array_filter(array: $tasks, callback: function(\DoEveryApp\Entity\Task $task) {
            if (false === $task->isActive()) {
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': skipping task: ' . $task->getId());
                return false;
            }
            if (false === $task->isNotify()) {
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': skipping task: ' . $task->getId());
                return false;
            }
            if (null === $task->getDueValue()) {
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': using task: ' . $task->getId());
                return true;
            }
            if ($task->getDueValue() < 0) {
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': using task: ' . $task->getId());
                return true;
            }

            $use = true === \in_array(
                    needle: $task->getDueUnit(),
                    haystack: [
                        \DoEveryApp\Definition\IntervalType::HOUR->value,
                        \DoEveryApp\Definition\IntervalType::MINUTE->value,
                    ]
                );
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': using task: ' . $task->getId() . ': ' . ($use ? 'true' : 'false') . '');
            return $use;
        });

        $hasTasks = false;
        foreach (\DoEveryApp\Util\View\TaskSortByDue::sort(tasks: $tasks) as $task) {
            foreach ($this->containers as $container) {
                $container->addItem(item: new \DoEveryApp\Util\Cron\Notification\Item\TaskDue(task: $task));
                $hasTasks = true;
            }
        }
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': has tasks: ' . ($hasTasks ? 'true' : 'false') . '');
        if (true === $hasTasks) {
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': notifying');
            $this->notify();
        }
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
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: __FILE__.'::'.__LINE__.': skipping empty container');
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
