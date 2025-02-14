<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Timer
{
    public function isRunning(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
        return null !== \DoEveryApp\Entity\Task\Timer\Section::getRepository()
                                                             ->createQueryBuilder('section')
                                                             ->innerJoin('section.timer', 'timer')
                                                             ->innerJoin('timer.task', 'task')
                                                             ->andWhere('task.id = :taskId')
                                                             ->setParameter('taskId', $task->getId())
                                                             ->andWhere('timer.worker = :workerId')
                                                             ->setParameter('workerId', $worker->getId())
                                                             ->getQuery()
                                                             ->getOneOrNullResult()
        ;
    }

    public function isPaused(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
    }

    public function startOrContinue(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
        /**
         * check if an unstopped exists, if yes, check if a running exists. if no, start a new one, if yes, just continue.
         * if no, start a new timer, start a new section
         */

        $runningTimer = \DoEveryApp\Entity\Task\Timer::getRepository()
            ->createQueryBuilder('timer')
            ->andWhere('timer.task = :taskId')
            ->setParameter('taskId', $task->getId())
            ->andWhere('timer.worker = :workerId')
            ->setParameter('workerId', $worker->getId())
            ->andWhere('timer.stopped = false')
            ->getQuery()
            ->getOneOrNullResult()
            ;

        $newTimer   = new \DoEveryApp\Entity\Task\Timer()
            ->setWorker($worker)
            ->setTask($task)
        ;
        $newTimer::getRepository()->create($newTimer);
        $nesSection = new \DoEveryApp\Entity\Task\Timer\Section()
            ->setTimer($newTimer)
            ->setStart(\Carbon\Carbon::now())
        ;
        $nesSection::getRepository()->create($nesSection);
        DependencyContainer::getInstance()->getEntityManager()->flush();
    }

    public function pause(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
    }

    public function stop(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
    }

}