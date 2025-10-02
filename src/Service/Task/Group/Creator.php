<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task\Group;

class Creator
{
    public static function execute(Creator\Bag $bag): \DoEveryApp\Entity\Group
    {
        $group = new \DoEveryApp\Entity\Group()
            ->setName(name: $bag->getName())
            ->setColor(color: $bag->getColor())
        ;

        $group::getRepository()->create(entity: $group);

        return $group;
    }
}
