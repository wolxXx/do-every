<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$hasSomething =
    0 !== \DoEveryApp\Entity\Execution::getRepository()->count()
    && 0 !== \DoEveryApp\Entity\Notification::getRepository()->count()
    && 0 !== \DoEveryApp\Entity\Task::getRepository()->count()
    && 0 !== \DoEveryApp\Entity\Worker::getRepository()->count();


if (true === $hasSomething) {
    echo 'nothing to do';

    return;
}

$you     = \DoEveryApp\Service\Worker\Creator::execute(
    (new \DoEveryApp\Service\Worker\Creator\Bag())
        ->setName('you')
        ->setIsAdmin(true)
        ->setEmail('login@do-every.app')
        ->setPassword(\DoEveryApp\Util\Password::hash('password'))
);
$workers = [];
foreach (range(2, rand(3, 20)) as $counter) {
    $workers[] = \DoEveryApp\Service\Worker\Creator::execute(
        (new \DoEveryApp\Service\Worker\Creator\Bag())
            ->setName('worker' . $counter)
    );
}

$groups = [];
foreach (range(2, rand(3, 20)) as $counter) {
    $group    = \DoEveryApp\Service\Task\Group\Creator::execute(
        (new \DoEveryApp\Service\Task\Group\Creator\Bag())
            ->setName('group' . $counter)
            ->setColor(rand(0, 100) > 80 ? \Faker\Factory::create()->hexColor() : null)
    );
    $groups[] = $group;
}

$types = [
    \DoEveryApp\Definition\IntervalType::MINUTE,
    \DoEveryApp\Definition\IntervalType::HOUR,
    \DoEveryApp\Definition\IntervalType::DAY,
    \DoEveryApp\Definition\IntervalType::MONTH,
    \DoEveryApp\Definition\IntervalType::YEAR,
];

foreach (range(0, 100) as $counter) {
    $task = \DoEveryApp\Service\Task\Creator::execute(
        (new \DoEveryApp\Service\Task\Creator\Bag())
            ->setGroup(rand(0, 100) > 50 ? $groups[array_rand($groups)] : null)
            ->setAssignee(rand(0, 100) > 50 ? $workers[array_rand($workers)] : (rand(0, 100) > 50 ? $you : null))
            ->setWorkingOn(rand(0, 100) > 50 ? $workers[array_rand($workers)] : (rand(0, 100) > 50 ? $you : null))
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