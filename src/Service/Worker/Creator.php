<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Worker;

class Creator
{
    public static function execute(Creator\Bag $bag): \DoEveryApp\Entity\Worker
    {
        $defaultWorker = new \DoEveryApp\Entity\Worker()
            ->setName(name: $bag->getName())
            ->setIsAdmin(admin: $bag->isAdmin())
            ->enableNotifications(notify: $bag->doNotify())
            ->setNotifyLogin(notifyLogin: $bag->doNotifyLogins())
        ;
        if (null !== $bag->getEmail()) {
            $defaultWorker->setEmail(email: $bag->getEmail());
        }

        if (null !== $bag->getPassword()) {
            $defaultWorker
                ->setHashedPassword(password: $bag->getPassword())
                ->setLastPasswordChange(lastPasswordChange: \Carbon\Carbon::now())
            ;
        }

        $defaultWorker::getRepository()->create(entity: $defaultWorker);

        return $defaultWorker;
    }
}
