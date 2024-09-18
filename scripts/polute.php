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

foreach (range(0, 10000) as $counter) {
    $task = \DoEveryApp\Service\Task\Creator::execute(
        (new \DoEveryApp\Service\Task\Creator\Bag())
            ->setGroup(rand(0, 100) > 50 ? $groups[array_rand($groups)] : null)
            ->setAssignee(rand(0, 100) > 50 ? $workers[array_rand($workers)] : null)
            ->setWorkingOn(rand(0, 100) > 50 ? $workers[array_rand($workers)] : null)
            ->setName('task' . $counter)
            ->setIntervalValue(rand(1, 50))
            ->setIntervalType($types[array_rand($types)])
    );

    if (rand(0, 100) > 50) {
        continue;
    }
    \DoEveryApp\Service\Task\Execution\Creator::execute(
        (new \DoEveryApp\Service\Task\Execution\Creator\Bag())
            ->setTask($task)
            ->setDate(\Faker\Factory::create()->dateTime)
            ->setWorker($workers[array_rand($workers)])
            ->setDuration(rand(1, 50))
            ->setNote(\Faker\Factory::create()->text(500))
    );
}

\DoEveryApp\Util\DependencyContainer::getInstance()
                                    ->getEntityManager()
                                    ->flush()
;