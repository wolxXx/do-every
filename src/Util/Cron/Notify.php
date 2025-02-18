<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron;

class Notify
{
    /**
     * @var \DoEveryApp\Entity\Task[]
     */
    public array $tasks = [];

    /**
     * @var \DoEveryApp\Entity\Worker[]
     */
    public array $workers = [];

    public function __construct()
    {
        $now             = \Carbon\Carbon::now();
        $notifierLastRun = \DoEveryApp\Util\Registry::getInstance()->getNotifierLastRun();
        $force           = false;
        $lastCron        = \Carbon\Carbon::create(year: $notifierLastRun);
        $lastCron->addHours(23);
        if ($lastCron->gt($now)) {
            $force = true;
        }

        if (true === \DoEveryApp\Util\Registry::getInstance()->isNotifierRunning()) {
            if (true !== $force) {
                return;
            }
        }

        \DoEveryApp\Util\Registry::getInstance()->setNotifierRunning(notifierRunning: true);
        \DoEveryApp\Util\DependencyContainer::getInstance()->getEntityManager()->flush();

        $workers       = \DoEveryApp\Entity\Worker::getRepository()->findAll();
        $this->workers = \array_filter(array: $workers, callback: function (\DoEveryApp\Entity\Worker $worker) use ($now) {
            if (null === $worker->getEmail() || false === $worker->doNotify()) {
                return false;
            }
            $lastNotification = \DoEveryApp\Entity\Notification::getRepository()->getLastForWorker(worker: $worker);
            if (null === $lastNotification) {
                return true;
            }
            $notificationDate = $lastNotification->getDate();
            $date             = \Carbon\Carbon::create(year: $notificationDate);
            $diff             = $date->diff($now, true, ['y', 'm']);

            return $diff->d > 0 || $diff->h > 22;
        },);
        $tasks         = \DoEveryApp\Entity\Task::getRepository()->findAll();
        $tasks         = \array_filter(array: $tasks, callback: function (\DoEveryApp\Entity\Task $task) {
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
                ],);
        },);
        $this->tasks   = \DoEveryApp\Util\View\TaskSortByDue::sort(tasks: $tasks);

        foreach ($this->workers as $worker) {
            \DoEveryApp\Util\Debugger::debug($worker->getName() . '->' . $worker->getEmail());
        }
        foreach ($this->tasks as $task) {
            \DoEveryApp\Util\Debugger::debug($task->getName() . '->' . $task->getDueValue() . ' ' . $task->getDueUnit() . ' ' . \DoEveryApp\Util\View\Due::getByTask(task: $task));
        }
        \DoEveryApp\Util\Debugger::debug($this->hasSomethingToDo());
        if (0 !== count(value: $this->tasks)) {
            $this->notify();
        }
        \DoEveryApp\Util\Registry::getInstance()->setNotifierRunning(notifierRunning: false);
        \DoEveryApp\Util\Registry::getInstance()->setNotifierLastRun(notifierLastRun: \Carbon\Carbon::now());
        \DoEveryApp\Util\DependencyContainer::getInstance()->getEntityManager()->flush();
    }

    public function notify(): void
    {
        foreach ($this->workers as $worker) {
            try {
                $tasks = [];
                foreach ($this->tasks as $task) {
                    $tasks[]      = $task;
                    $notification = (new \DoEveryApp\Entity\Notification())
                        ->setWorker(worker: $worker)
                        ->setTask(task: $task)
                        ->setDate(date: \Carbon\Carbon::now())
                    ;
                    $notification::getRepository()->create(entity: $notification);
                }
                \DoEveryApp\Util\Mailing\Notify::send(worker: $worker, tasks: $tasks);
            } catch (\Throwable $exception) {
                \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->error(message: 'notification mail failed. ' . $exception->getMessage() . \PHP_EOL . \PHP_EOL . $exception->getTraceAsString());
            }
        }
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
    }

    public function hasSomethingToDo(): bool
    {
        return 0 !== count(value: $this->tasks) && 0 !== count(value: $this->workers);
    }
}
