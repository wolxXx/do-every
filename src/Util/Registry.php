<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Registry
{
    public const string KEY_ADMIN_USER = '7e0b853b-7e45-4e17-9458-89803fcd2c1e';

    public const string KEY_LAST_CRON  = '449b1579-5540-4d06-b076-dfcfea73ff3c';


    public function getRow(string $key): ?\DoEveryApp\Entity\Registry
    {
        return \DoEveryApp\Entity\Registry::getRepository()->getByKey($key);
    }


    public function rowExists(string $key): bool
    {
        return $this->getRow($key) instanceof \DoEveryApp\Entity\Registry;
    }


    public function getOrCreateRow(string $key): \DoEveryApp\Entity\Registry
    {
        if (false === $this->rowExists($key)) {
            $registry = (new \DoEveryApp\Entity\Registry())
                ->setKey($key)
            ;
            $registry::getRepository()->create($registry);

            return $registry;
        }

        return $this->getRow($key);
    }


    public function updateRow(\DoEveryApp\Entity\Registry $registry): static
    {
        $registry::getRepository()->update($registry);
        DependencyContainer::getInstance()
                           ->getEntityManager()
                           ->flush()
        ;

        return $this;
    }


    public function getAdminUser(): ?\DoEveryApp\Entity\Worker
    {
        return $this
            ->getRow(self::KEY_ADMIN_USER)
            ?->getWorkerCascade()
        ;
    }


    public function setAdminUser(?\DoEveryApp\Entity\Worker $worker): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_ADMIN_USER)
                ->setWorkerCascade($worker)
        );
    }


    public function getLastCron(): ?\DateTime
    {
        return $this
            ->getRow(self::KEY_LAST_CRON)
            ?->getDateValue()
        ;
    }


    public function setLastCron(?\DateTime $lastCron): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_LAST_CRON)
                ->setDateValue($lastCron)
        );
    }
}
