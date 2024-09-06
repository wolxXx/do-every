<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task;

class Creator
{
    public static function execute(Creator\Bag $bag): \DoEveryApp\Entity\Task
    {
        $task = (new \DoEveryApp\Entity\Task())
            ->setGroup($bag->getGroup())
            ->setAssignee($bag->getAssignee())
            ->setWorkingOn($bag->getWorkingOn())
            ->setName($bag->getName())
            ->setNotify($bag->doNotify())
            ->setActive($bag->isActive())
            ->setPriority($bag->getPriority()->value)
            ->setIntervalType($bag->getIntervalType()->value)
            ->setIntervalValue($bag->getIntervalValue())
            ->setElapsingCronType($bag->isElapsingCronType())
            ->setNote($bag->getNote())
        ;

        $task::getRepository()->create($task);

        return $task;
    }
}