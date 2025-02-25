<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$hasSomething
    = 0 !== \DoEveryApp\Entity\Execution::getRepository()->count()
      && 0 !== \DoEveryApp\Entity\Notification::getRepository()->count()
      && 0 !== \DoEveryApp\Entity\Task::getRepository()->count()
      && 0 !== \DoEveryApp\Entity\Worker::getRepository()->count();


if (true === $hasSomething) {
    echo 'nothing to do';

    return;
}

$you     = \DoEveryApp\Service\Worker\Creator::execute(
    bag: (new \DoEveryApp\Service\Worker\Creator\Bag())
        ->setName(name: 'Mazel Tov')
        ->setIsAdmin(admin: true)
        ->setEmail(email: 'do-every@kwatsh.de')
        ->setPassword(password: 'Passwort')
);
$workers = [];
foreach (range(start: 2, end: rand(min: 3, max: 10)) as $counter) {
    $workers[] = \DoEveryApp\Service\Worker\Creator::execute(
        bag: (new \DoEveryApp\Service\Worker\Creator\Bag())
            ->setName(name: 'worker' . $counter)
    );
}

$groups = [];
foreach (range(start: 2, end: rand(min: 3, max: 10)) as $counter) {
    $group    = \DoEveryApp\Service\Task\Group\Creator::execute(
        bag: (new \DoEveryApp\Service\Task\Group\Creator\Bag())
            ->setName(name: 'group' . $counter)
            ->setColor(color: rand(min: 0, max: 100) > 80 ? \Faker\Factory::create()->hexColor() : null)
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

foreach (range(start: 0, end: 20) as $counter) {
    $task = \DoEveryApp\Service\Task\Creator::execute(
        bag: (new \DoEveryApp\Service\Task\Creator\Bag())
            ->setGroup(group: rand(min: 0, max: 100) > 50 ? $groups[array_rand(array: $groups)] : null)
            ->setAssignee(assignee: rand(min: 0, max: 100) > 50 ? $workers[array_rand(array: $workers)] : (rand(min: 0, max: 100) > 50 ? $you : null))
            ->setWorkingOn(workingOn: rand(min: 0, max: 100) > 50 ? $workers[array_rand(array: $workers)] : (rand(min: 0, max: 100) > 50 ? $you : null))
            ->setName(name: 'task' . $counter)
            ->setIntervalValue(intervalValue: rand(min: 1, max: 50))
            ->setIntervalType(intervalType: $types[array_rand(array: $types)])
            ->enableNotifications(notify: false)
    );

    if (rand(min: 0, max: 100) > 50) {
        continue;
    }
    \DoEveryApp\Service\Task\Execution\Creator::execute(
        bag: (new \DoEveryApp\Service\Task\Execution\Creator\Bag())
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