<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';


$workers = \DoEveryApp\Entity\Worker::getRepository()->findAll();
$groups = \DoEveryApp\Entity\Group::getRepository()->findAll();
$types = [
    \DoEveryApp\Definition\IntervalType::MINUTE,
    \DoEveryApp\Definition\IntervalType::HOUR,
    \DoEveryApp\Definition\IntervalType::DAY,
    \DoEveryApp\Definition\IntervalType::MONTH,
    \DoEveryApp\Definition\IntervalType::YEAR,
];

foreach (range(start: 0, end: 10000) as $counter) {
    $task = \DoEveryApp\Service\Task\Creator::execute(
        bag: new \DoEveryApp\Service\Task\Creator\Bag()
            ->setGroup(group: rand(min: 0, max: 100) > 50 ? $groups[array_rand(array: $groups)] : null)
            ->setAssignee(assignee: rand(min: 0, max: 100) > 50 ? $workers[array_rand(array: $workers)] : null)
            ->setWorkingOn(workingOn: rand(min: 0, max: 100) > 50 ? $workers[array_rand(array: $workers)] : null)
            ->setName(name: 'task' . $counter)
            ->setTaskType(taskType: \DoEveryApp\Definition\TaskType::RELATIVE)
            ->setIntervalValue(intervalValue: rand(min: 1, max: 50))
            ->setIntervalType(intervalType: $types[array_rand(array: $types)])
    );

    if (rand(min: 0, max: 100) > 50) {
        continue;
    }
    \DoEveryApp\Service\Task\Execution\Creator::execute(
        bag: new \DoEveryApp\Service\Task\Execution\Creator\Bag()
            ->setTask(task: $task)
            ->setDate(date: \Faker\Factory::create()->dateTime)
            ->setWorker(worker: $workers[array_rand(array: $workers)])
            ->setDuration(duration: rand(min: 1, max: 50))
            ->setNote(note: \Faker\Factory::create()->text(maxNbChars: 500))
    );
}

\DoEveryApp\Util\DependencyContainer::getInstance()
                                    ->getEntityManager()
                                    ->flush()
;