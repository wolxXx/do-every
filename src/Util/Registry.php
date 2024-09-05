<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Registry
{
    private const string KEY_ADMIN_USER = '7e0b853b-7e45-4e17-9458-89803fcd2c1e';

    private const string KEY_LAST_CRON  = '449b1579-5540-4d06-b076-dfcfea73ff3c';

    private const string KEY_MAX_GROUPS = 'e15e9173-2776-4848-9419-0dfc0112db62';

    private const string KEY_MAX_TASKS  = 'd5a3211d-7e3f-4db8-98f0-339036409289';

    private const string KEY_MAX_USERS  = '0e18481e-767b-41c7-b74a-31b4ffc6bc01';

    private static Registry $instance;

    public static function getInstance(): static
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }


    private function getRow(string $key): ?\DoEveryApp\Entity\Registry
    {
        return \DoEveryApp\Entity\Registry::getRepository()->getByKey($key);
    }


    private function rowExists(string $key): bool
    {
        return $this->getRow($key) instanceof \DoEveryApp\Entity\Registry;
    }


    private function getOrCreateRow(string $key): \DoEveryApp\Entity\Registry
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


    private function updateRow(\DoEveryApp\Entity\Registry $registry): static
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


    public function getMaxUsers(): ?int
    {
        return $this
            ->getRow(self::KEY_LAST_CRON)
            ?->getIntValue()
        ;
    }


    public function setMaxUsers(?int $maxUsers): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_MAX_USERS)
                ->setIntValue($maxUsers)
        );
    }


    public function getMaxTasks(): ?int
    {
        return $this
            ->getRow(self::KEY_MAX_TASKS)
            ?->getIntValue()
        ;
    }


    public function setMaxTasks(?int $maxTasks): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_MAX_TASKS)
                ->setIntValue($maxTasks)
        );
    }


    public function getMaxGroups(): ?int
    {
        return $this
            ->getRow(self::KEY_MAX_GROUPS)
            ?->getIntValue()
        ;
    }


    public function setMaxGroups(?int $maxGroups): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_MAX_GROUPS)
                ->setIntValue($maxGroups)
        );
    }
}
