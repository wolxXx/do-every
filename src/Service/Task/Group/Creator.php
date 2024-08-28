<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task\Group;

class Creator
{
    public static function execute(Group\Bag $bag): \DoEveryApp\Entity\Group
    {
        $group = (new \DoEveryApp\Entity\Group())
            ->setName($bag->getName())
            ->setColor($bag->getColor())
        ;

        $group::getRepository()->create($group);

        return $group;
    }
}