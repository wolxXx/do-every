<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Timer
{
    public function isRunning(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
        return null !== \DoEveryApp\Entity\Task\Timer\Section::getRepository()
                ->createQueryBuilder(alias: 'section')
                ->innerJoin(join: 'section.timer', alias: 'timer')
                ->innerJoin(join: 'timer.task', alias: 'task')
                ->andWhere('task.id = :taskId')
                ->setParameter(key: 'taskId', value: $task->getId())
                ->andWhere('timer.worker = :workerId')
                ->setParameter(key: 'workerId', value: $worker->getId())
                ->andWhere('timer.stopped = false')
                ->andWhere('section.end IS NULL')
                ->getQuery()
                ->getOneOrNullResult();
    }

    public function isPaused(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
        return null === \DoEveryApp\Entity\Task\Timer\Section::getRepository()
                ->createQueryBuilder(alias: 'section')
                ->innerJoin(join: 'section.timer', alias: 'timer')
                ->innerJoin(join: 'timer.task', alias: 'task')
                ->andWhere('task.id = :taskId')
                ->setParameter(key: 'taskId', value: $task->getId())
                ->andWhere('timer.worker = :workerId')
                ->setParameter(key: 'workerId', value: $worker->getId())
                ->andWhere('timer.stopped = false')
                ->andWhere('section.end IS NOT NULL')
                ->getQuery()
                ->getOneOrNullResult();
    }

    public function startOrContinue(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
        /**
         * check if an unstopped exists, if yes, check if a running exists. if no, start a new one, if yes, just continue.
         * if no, start a new timer, start a new section
         */

        $runningTimer = \DoEveryApp\Entity\Task\Timer::getRepository()
            ->createQueryBuilder(alias: 'timer')
            ->andWhere('timer.task = :taskId')
            ->setParameter(key: 'taskId', value: $task->getId())
            ->andWhere('timer.worker = :workerId')
            ->setParameter(key: 'workerId', value: $worker->getId())
            ->andWhere('timer.stopped = false')
            ->getQuery()
            ->getOneOrNullResult();
        if (true === $runningTimer instanceof \DoEveryApp\Entity\Task\Timer) {
            $activeSection = \DoEveryApp\Entity\Task\Timer\Section::getRepository()
                ->createQueryBuilder(alias: 'section')
                ->andWhere('section.timer = :timer')
                ->setParameter(key: 'timer', value: $runningTimer)
                ->andWhere('section.end IS NULL')
                ->getQuery()
                ->getOneOrNullResult();
            if (true === $activeSection instanceof \DoEveryApp\Entity\Task\Timer\Section) {
                return true;
            }
            $activeSection = new \DoEveryApp\Entity\Task\Timer\Section()
                ->setTimer(timer: $runningTimer)
                ->setStart(start: \Carbon\Carbon::now());
            $activeSection::getRepository()->create(entity: $activeSection);
            DependencyContainer::getInstance()
                ->getEntityManager()
                ->flush();

            return true;
        }

        $newTimer = new \DoEveryApp\Entity\Task\Timer()
            ->setWorker(worker: $worker)
            ->setTask(task: $task);
        $newTimer::getRepository()->create(entity: $newTimer);
        $nesSection = new \DoEveryApp\Entity\Task\Timer\Section()
            ->setTimer(timer: $newTimer)
            ->setStart(start: \Carbon\Carbon::now());
        $nesSection::getRepository()->create(entity: $nesSection);
        DependencyContainer::getInstance()->getEntityManager()->flush();

        return true;
    }

    public function pause(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
    }

    public function stop(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
    }

}