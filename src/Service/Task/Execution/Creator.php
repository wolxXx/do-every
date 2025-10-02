<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task\Execution;

class Creator
{
    public static function execute(Creator\Bag $bag): \DoEveryApp\Entity\Execution
    {
        $execution = new \DoEveryApp\Entity\Execution()
            ->setTask(task: $bag->getTask())
            ->setWorker(worker: $bag->getWorker())
            ->setDate(date: $bag->getDate())
            ->setNote(note: $bag->getNote())
            ->setDuration(duration: $bag->getDuration())
        ;

        $execution::getRepository()->create(entity: $execution);

        return $execution;
    }
}
