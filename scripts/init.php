<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$hasSomething =
    0 !== \DoEveryApp\Entity\Execution::getRepository()->count()
    && 0 !== \DoEveryApp\Entity\Notification::getRepository()->count()
    && 0 !== \DoEveryApp\Entity\Task::getRepository()->count()
    && 0 !== \DoEveryApp\Entity\Worker::getRepository()->count();

\DoEveryApp\Util\Debugger::debug($hasSomething);

if (true === $hasSomething) {
    echo 'nothing to do';
}

\DoEveryApp\Service\Worker\Creator::execute(
    (new \DoEveryApp\Service\Worker\Creator\Bag())
        ->setName('du')
        ->setIsAdmin(true)
);


$task = (new \DoEveryApp\Entity\Task())
    ->setName('delete me!')
    ->setPriority(\DoEveryApp\Definition\Priority::NORMAL->value)
    ->setIntervalType(\DoEveryApp\Definition\IntervalType::HOUR->value)
    ->setIntervalValue(100)
    ->setNotify(true);

\DoEveryApp\Util\DependencyContainer::getInstance()
                                    ->getEntityManager()
                                    ->flush()
;