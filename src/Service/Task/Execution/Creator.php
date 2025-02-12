<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task\Execution;

class Creator
{
    public static function execute(Creator\Bag $bag): \DoEveryApp\Entity\Execution
    {
        $execution = (new \DoEveryApp\Entity\Execution())
            ->setTask($bag->getTask())
            ->setWorker($bag->getWorker())
            ->setDate($bag->getDate())
            ->setNote($bag->getNote())
            ->setDuration($bag->getDuration())
        ;

        $execution::getRepository()->create($execution);

        return $execution;
    }
}
