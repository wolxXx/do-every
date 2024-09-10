<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

final class Registry
{
    private const string KEY_ADMIN_USER       = '7e0b853b-7e45-4e17-9458-89803fcd2c1e';

    private const string KEY_CRON_LOCK        = '84c29c0a-cbd9-4bc6-8532-feb785f4c59d';

    private const string KEY_CRON_STARTED     = '05226812-dcf8-4e36-89ac-1dccc3e06047';

    private const string KEY_FILL_TIME_LINE   = '49a4421b-b6f4-458e-a7cd-5253a78305db';

    private const string KEY_KEEP_BACKUP_DAYS = 'fbc976e8-629c-4f49-b17c-88a82482def3';

    private const string KEY_LAST_BACKUP      = 'e16ede03-9703-4ce3-a075-88d4a64706cb';

    private const string KEY_LAST_CRON        = '449b1579-5540-4d06-b076-dfcfea73ff3c';

    private const string KEY_MAX_GROUPS       = 'e15e9173-2776-4848-9419-0dfc0112db62';

    private const string KEY_MAX_TASKS        = 'd5a3211d-7e3f-4db8-98f0-339036409289';

    private const string KEY_MAX_WORKERS      = '0e18481e-767b-41c7-b74a-31b4ffc6bc01';

    private const string KEY_PRECISION_DUE    = '902069d4-7b4a-4c04-9af5-0d1432ac105d';

    private static Registry $instance;


    public static function getInstance(): static
    {
        if (false === isset(static::$instance)) {
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


    #region crons

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


    public function getCronStarted(): ?\DateTime
    {
        return $this
            ->getRow(self::KEY_CRON_STARTED)
            ?->getDateValue()
        ;
    }


    public function setCronStarted(\DateTime $cronStarted): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_CRON_STARTED)
                ->setDateValue($cronStarted)
        );
    }


    public function isCronRunning(): bool
    {
        return true === $this
                ->getRow(self::KEY_CRON_LOCK)
                ?->getBoolValue()
        ;
    }


    public function setCronRunning(bool $cronRunning): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_CRON_LOCK)
                ->setBoolValue($cronRunning)
        );
    }


    #endregion crons


    public function getKeepBackupDays(): int
    {
        return $this
            ->getRow(self::KEY_KEEP_BACKUP_DAYS)
            ?->getIntValue()
            ?? 30
        ;
    }


    public function setKeepBackupDays(?int $days): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_KEEP_BACKUP_DAYS)
                ->setIntValue($days)
        );
    }

    public function getLastBackup(): ?\DateTime
    {
        return $this
            ->getRow(self::KEY_LAST_BACKUP)
            ?->getDateValue()
        ;
    }


    public function setLastBackup(\DateTime $lastBackup): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_LAST_BACKUP)
                ->setDateValue($lastBackup)
        );
    }


    public function getMaxWorkers(): ?int
    {
        return $this
            ->getRow(self::KEY_MAX_WORKERS)
            ?->getIntValue()
        ;
    }


    public function setMaxWorkers(?int $maxWorkers): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_MAX_WORKERS)
                ->setIntValue($maxWorkers)
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


    public function getPrecisionDue(): int
    {
        return $this
            ->getRow(self::KEY_PRECISION_DUE)
            ?->getIntValue()
            ?? 3;
    }


    public function setPrecisionDue(?int $precisionDue): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_PRECISION_DUE)
                ->setIntValue($precisionDue)
        );
    }


    public function doFillTimeLine(): bool
    {
        return $this
            ->getRow(self::KEY_FILL_TIME_LINE)
            ?->getBoolValue()
            ?: false;
    }


    public function setDoFillTimeLine(?bool $fillTimeLine): static
    {
        return $this->updateRow(
            $this
                ->getOrCreateRow(self::KEY_FILL_TIME_LINE)
                ->setBoolValue($fillTimeLine)
        );
    }
}
