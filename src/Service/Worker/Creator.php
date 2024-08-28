<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Worker;

class Creator
{
    public static function execute(Creator\Bag $bag): \DoEveryApp\Entity\Worker
    {
        $defaultWorker = (new \DoEveryApp\Entity\Worker())
            ->setName($bag->getName())
            ->setIsAdmin($bag->isAdmin())
            ->enableNotifications($bag->doNotify())
        ;
        if (null !== $bag->getEmail()) {
            $defaultWorker->setEmail($bag->getEmail());
        }

        if (null !== $bag->getPassword()) {
            $defaultWorker->setPassword($bag->getPassword());
        }

        $defaultWorker::getRepository()->create($defaultWorker);

        return $defaultWorker;
    }
}