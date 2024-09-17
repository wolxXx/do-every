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
        $now = \Carbon\Carbon::now();

        if (true === \DoEveryApp\Util\Registry::getInstance()->isNotifierRunning()) {
            return;
        }

        $notifierLastRun = \DoEveryApp\Util\Registry::getInstance()->getNotifierLastRun();
        $diff            = $now->diff($notifierLastRun, true, ['y', 'm', 'd', 'h']);
        if ($diff->d > 0 || $diff->h > 6) {
            return;
        }

        \DoEveryApp\Util\Registry::getInstance()->setNotifierRunning(true);
        \DoEveryApp\Util\DependencyContainer::getInstance()->getEntityManager()->flush();

        $workers       = \DoEveryApp\Entity\Worker::getRepository()->findAll();
        $this->workers = \array_filter($workers, function (\DoEveryApp\Entity\Worker $worker) use ($now) {
            if (null === $worker->getEmail() || false === $worker->doNotify()) {
                return false;
            }
            $lastNotification = \DoEveryApp\Entity\Notification::getRepository()->getLastForWorker($worker);
            if (null === $lastNotification) {
                return true;
            }
            $notificationDate = $lastNotification->getDate();
            $date             = \Carbon\Carbon::create($notificationDate);
            $diff             = $date->diff($now, true, ['y', 'm']);

            return $diff->d > 0 || $diff->h > 22;
        });
        $tasks         = \DoEveryApp\Entity\Task::getRepository()->findAll();
        $tasks         = \array_filter($tasks, function (\DoEveryApp\Entity\Task $task) {
            if (false === $task->isNotify()) {
                return false;
            }
            if (null === $task->getDueValue()) {
                return true;
            }
            if ($task->getDueValue() < 0) {
                return true;
            }

            return true === \in_array($task->getDueUnit(), [
                    \DoEveryApp\Definition\IntervalType::HOUR->value,
                    \DoEveryApp\Definition\IntervalType::MINUTE->value,
                ]);
        });
        $this->tasks   = \DoEveryApp\Util\View\TaskSortByDue::sort($tasks);

        foreach ($this->workers as $worker) {
            \DoEveryApp\Util\Debugger::debug($worker->getName() . '->' . $worker->getEmail());
        }
        foreach ($this->tasks as $task) {
            \DoEveryApp\Util\Debugger::debug($task->getName() . '->' . $task->getDueValue() . ' ' . $task->getDueUnit() . ' ' . \DoEveryApp\Util\View\Due::getByTask($task));
        }
        \DoEveryApp\Util\Debugger::debug($this->hasSomethingToDo());
        $this->notify();
        \DoEveryApp\Util\Registry::getInstance()->setNotifierRunning(false);
        \DoEveryApp\Util\Registry::getInstance()->setNotifierLastRun(\Carbon\Carbon::now());
        \DoEveryApp\Util\DependencyContainer::getInstance()->getEntityManager()->flush();
    }


    public function notify()
    {
        foreach ($this->workers as $worker) {
            $tasks = [];
            foreach ($this->tasks as $task) {
                $tasks[]      = $task;
                $notification = (new \DoEveryApp\Entity\Notification())
                    ->setWorker($worker)
                    ->setTask($task)
                    ->setDate(\Carbon\Carbon::now())
                ;
                $notification::getRepository()->create($notification);
            }
            \DoEveryApp\Util\Mailing\Notify::send($worker, $tasks);
        }
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
    }


    public function hasSomethingToDo(): bool
    {
        return 0 !== \sizeof($this->tasks) && 0 !== \sizeof($this->workers);
    }
}