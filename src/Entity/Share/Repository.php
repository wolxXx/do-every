<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Share;


trait Repository
{
    protected static function getRepositoryByClassName(): \Doctrine\ORM\EntityRepository
    {
        return \DoEveryApp\Util\DependencyContainer::getInstance()
                                                    ->getEntityManager()
                                                    ->getRepository(__CLASS__)
        ;
    }
}