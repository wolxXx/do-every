<?php

declare(strict_types = 1);

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
                                                             ->getOneOrNullResult()
        ;
    }

    public function getRunning(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): ?\DoEveryApp\Entity\Task\Timer
    {
        return \DoEveryApp\Entity\Task\Timer\Section::getRepository()
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
                                                    ->getOneOrNullResult()
                                                    ?->getTimer()
        ;
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
                                                             ->getOneOrNullResult()
        ;
    }

    public function getPaused(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): ?\DoEveryApp\Entity\Task\Timer
    {
        return \DoEveryApp\Entity\Task\Timer::getRepository()
                                            ->createQueryBuilder(alias: 'timer')
                                            ->leftJoin(join     : 'timer.sections', alias: 'section', conditionType: \Doctrine\ORM\Query\Expr\Join::WITH,
                                                       condition: 'section.timer = timer AND section.end IS NULL')
                                            ->innerJoin(join: 'timer.task', alias: 'task')
                                            ->andWhere('task.id = :taskId')
                                            ->setParameter(key: 'taskId', value: $task->getId())
                                            ->andWhere('timer.worker = :workerId')
                                            ->setParameter(key: 'workerId', value: $worker->getId())
                                            ->andWhere('timer.stopped = false')
                                            ->andWhere('section.id IS NULL')
                                            ->getQuery()
                                            ->getOneOrNullResult()
        ;
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
                                                     ->getOneOrNullResult()
        ;
        if (true === $runningTimer instanceof \DoEveryApp\Entity\Task\Timer) {
            $activeSection = \DoEveryApp\Entity\Task\Timer\Section::getRepository()
                                                                  ->createQueryBuilder(alias: 'section')
                                                                  ->andWhere('section.timer = :timer')
                                                                  ->setParameter(key: 'timer', value: $runningTimer)
                                                                  ->andWhere('section.end IS NULL')
                                                                  ->getQuery()
                                                                  ->getOneOrNullResult()
            ;
            if (true === $activeSection instanceof \DoEveryApp\Entity\Task\Timer\Section) {
                return true;
            }
            $activeSection = new \DoEveryApp\Entity\Task\Timer\Section()
                ->setTimer(timer: $runningTimer)
                ->setStart(start: \Carbon\Carbon::now())
            ;
            $activeSection::getRepository()
                          ->create(entity: $activeSection)
            ;
            DependencyContainer::getInstance()
                               ->getEntityManager()
                               ->flush()
            ;

            return true;
        }

        $newTimer = new \DoEveryApp\Entity\Task\Timer()
            ->setWorker(worker: $worker)
            ->setTask(task: $task)
        ;
        $newTimer::getRepository()
                 ->create(entity: $newTimer)
        ;
        $nesSection = new \DoEveryApp\Entity\Task\Timer\Section()
            ->setTimer(timer: $newTimer)
            ->setStart(start: \Carbon\Carbon::now())
        ;
        $nesSection::getRepository()
                   ->create(entity: $nesSection)
        ;
        DependencyContainer::getInstance()
                           ->getEntityManager()
                           ->flush()
        ;

        return false;
    }

    public function pause(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
        $runningTimer = \DoEveryApp\Entity\Task\Timer::getRepository()
                                                     ->createQueryBuilder(alias: 'timer')
                                                     ->andWhere('timer.task = :taskId')
                                                     ->setParameter(key: 'taskId', value: $task->getId())
                                                     ->andWhere('timer.worker = :workerId')
                                                     ->setParameter(key: 'workerId', value: $worker->getId())
                                                     ->andWhere('timer.stopped = false')
                                                     ->getQuery()
                                                     ->getOneOrNullResult()
        ;
        if (false === $runningTimer instanceof \DoEveryApp\Entity\Task\Timer) {
            return false;
        }
        $activeSection = \DoEveryApp\Entity\Task\Timer\Section::getRepository()
                                                              ->createQueryBuilder(alias: 'section')
                                                              ->andWhere('section.timer = :timer')
                                                              ->setParameter(key: 'timer', value: $runningTimer)
                                                              ->andWhere('section.end IS NULL')
                                                              ->getQuery()
                                                              ->getOneOrNullResult()
        ;
        if (false === $activeSection instanceof \DoEveryApp\Entity\Task\Timer\Section) {
            return false;
        }
        $activeSection->setEnd(end: \Carbon\Carbon::now());
        $activeSection::getRepository()
                      ->update(entity: $activeSection)
        ;
        DependencyContainer::getInstance()
                           ->getEntityManager()
                           ->flush()
        ;

        return true;
    }

    public function stop(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): bool
    {
        $paused = $this->getPaused(task: $task, worker: $worker);
        if (true === $paused instanceof \DoEveryApp\Entity\Task\Timer) {
            $paused->setStopped(stopped: true);
            $paused::getRepository()
                   ->update(entity: $paused)
            ;
            DependencyContainer::getInstance()
                               ->getEntityManager()
                               ->flush()
            ;

            return true;
        }
        $running = $this->getRunning(task: $task, worker: $worker);
        if (true === $running instanceof \DoEveryApp\Entity\Task\Timer) {
            foreach ($running->getSections() as $section) {
                if (null === $section->getEnd()) {
                    $section->setEnd(end: \Carbon\Carbon::now());
                    $section::getRepository()
                            ->update(entity: $section)
                    ;
                }
            }
            $running->setStopped(stopped: true);
            $running::getRepository()
                    ->update(entity: $running)
            ;
            DependencyContainer::getInstance()
                               ->getEntityManager()
                               ->flush()
            ;

            return true;
        }

        return true;
    }

    public function getLast(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): ?\DoEveryApp\Entity\Task\Timer
    {
        $timers = \DoEveryApp\Entity\Task\Timer::getRepository()
                                               ->createQueryBuilder(alias: 'timer')
                                               ->andWhere('timer.task = :taskId')
                                               ->setParameter(key: 'taskId', value: $task->getId())
                                               ->andWhere('timer.worker = :workerId')
                                               ->setParameter(key: 'workerId', value: $worker->getId())
                                               ->orderBy(sort: 'timer.id', order: 'DESC')
                                               ->getQuery()
                                               ->execute()
        ;
        foreach ($timers as $timer) {
            return $timer;
        }

        return null;
    }

    public function reset(\DoEveryApp\Entity\Task $task, \DoEveryApp\Entity\Worker $worker): void
    {
        DependencyContainer::getInstance()
                           ->getEntityManager()
                           ->createQueryBuilder()
                           ->delete(delete: \DoEveryApp\Entity\Task\Timer::class, alias: 'timer')
                           ->andWhere('timer.task = :taskId')
                           ->setParameter(key: 'taskId', value: $task->getId())
                           ->andWhere('timer.worker = :workerId')
                           ->setParameter(key: 'workerId', value: $worker->getId())
                           ->getQuery()
                           ->execute()
        ;
    }
}