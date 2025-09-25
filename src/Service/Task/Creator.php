<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task;

class Creator
{
    public static function execute(Creator\Bag $bag): \DoEveryApp\Entity\Task
    {
        $task = new \DoEveryApp\Entity\Task()
            ->setGroup(group: $bag->getGroup())
            ->setAssignee(assignee: $bag->getAssignee())
            ->setWorkingOn(workingOn: $bag->getWorkingOn())
            ->setName(name: $bag->getName())
            ->setType($bag->getTaskType())
            ->setNotify(notify: $bag->doNotify())
            ->setActive(active: $bag->isActive())
            ->setPriority(priority: $bag->getPriority()->value)
            ->setIntervalType(intervalType: $bag->getIntervalType()?->value)
            ->setIntervalValue(intervalValue: $bag->getIntervalValue())
            ->setDueDate(dueDate: $bag->getDueDate())
            ->setRemindDate(remindDate: $bag->getRemindDate())
            ->setNote(note: $bag->getNote())
        ;

        $task::getRepository()->create(entity: $task);

        return $task;
    }
}
