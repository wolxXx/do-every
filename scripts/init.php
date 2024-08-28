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

$you = \DoEveryApp\Service\Worker\Creator::execute(
    (new \DoEveryApp\Service\Worker\Creator\Bag())
        ->setName('you')
        ->setIsAdmin(true)
);
\DoEveryApp\Service\Worker\Creator::execute(
    (new \DoEveryApp\Service\Worker\Creator\Bag())
        ->setName('not you')
);

$groups = [];
foreach (range(2, rand(3, 20)) as $counter) {
    
}

foreach (range(0, 100) as $counter) {
    \DoEveryApp\Service\Task\Creator::execute(
        (new \DoEveryApp\Service\Task\Creator\Bag())
        ->setName('task' . $counter)
        ->setIntervalValue(rand(1,50))
        ->setIntervalType(\DoEveryApp\Definition\IntervalType::DAY)
    );
}

\DoEveryApp\Util\DependencyContainer::getInstance()
                                    ->getEntityManager()
                                    ->flush()
;