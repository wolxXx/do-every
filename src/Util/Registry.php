<?php

declare(strict_types = 1);

namespace DoEveryApp\Util;

final class Registry
{
    private static Registry $instance;

    private array           $map = [];


    public static function getInstance(): static
    {
        if (false === isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    final private function __construct()
    {
        foreach (\DoEveryApp\Entity\Registry::getRepository()->findAll() as $registry) {
            $this->map[$registry->getKey()] = $registry;
        }
    }


    private function getRow(string $key): ?\DoEveryApp\Entity\Registry
    {
        if (false === \array_key_exists(key: $key, array: $this->map)) {
            $registry        = \DoEveryApp\Entity\Registry::getRepository()
                                                          ->getByKey(key: $key)
            ;
            $this->map[$key] = $registry;

            return $registry;
        }

        return $this->map[$key];
    }


    private function rowExists(string $key): bool
    {
        return $this->getRow(key: $key) instanceof \DoEveryApp\Entity\Registry;
    }


    private function getOrCreateRow(string $key): \DoEveryApp\Entity\Registry
    {
        if (false === $this->rowExists(key: $key)) {
            \DoEveryApp\Entity\Registry::getRepository()
                                       ->create(entity: $registry = new \DoEveryApp\Entity\Registry()
                                           ->setKey(key: $key),
                                       )
            ;
            $this->map[$key] = $registry;

            return $registry;
        }

        return $this->getRow(key: $key);
    }


    private function updateRow(\DoEveryApp\Entity\Registry $registry): static
    {
        $registry::getRepository()
                 ->update(entity: $registry)
        ;
        DependencyContainer::getInstance()
                           ->getEntityManager()
                           ->flush()
        ;

        return $this;
    }


    public function getAdminUser(): ?\DoEveryApp\Entity\Worker
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_ADMIN_USER->value)
            ?->getWorkerCascade()
        ;
    }


    public function setAdminUser(?\DoEveryApp\Entity\Worker $worker): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_ADMIN_USER->value)
                          ->setWorkerCascade(workerCascade: $worker),
        );
    }


    #region crons

    public function getLastCron(): ?\DateTime
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_LAST_CRON->value)
            ?->getDateValue()
        ;
    }


    public function setLastCron(?\DateTime $lastCron): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_LAST_CRON->value)
                          ->setDateValue(dateValue: $lastCron),
        );
    }


    public function getCronStarted(): ?\DateTime
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_CRON_STARTED->value)
            ?->getDateValue()
        ;
    }


    public function setCronStarted(\DateTime $cronStarted): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_CRON_STARTED->value)
                          ->setDateValue(dateValue: $cronStarted),
        );
    }


    public function isCronRunning(): bool
    {
        return true === $this
                ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_CRON_LOCK->value)
                ?->getBoolValue()
        ;
    }


    public function setCronRunning(bool $cronRunning): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_CRON_LOCK->value)
                          ->setBoolValue(boolValue: $cronRunning),
        );
    }


    public function isNotifierRunning(): bool
    {
        return true === $this
                ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_NOTIFIER_RUNNING->value)
                ?->getBoolValue()
        ;
    }


    public function setNotifierRunning(bool $notifierRunning): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_NOTIFIER_RUNNING->value)
                          ->setBoolValue(boolValue: $notifierRunning),
        );
    }


    public function getNotifierLastRun(): ?\DateTime
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_NOTIFIER_LAST_RUN->value)
            ?->getDateValue()
        ;
    }


    public function setNotifierLastRun(\DateTime $notifierLastRun): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_NOTIFIER_LAST_RUN->value)
                          ->setDateValue(dateValue: $notifierLastRun),
        );
    }


    #endregion crons


    public function getKeepBackupDays(): int
    {
        return $this
                   ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_KEEP_BACKUP_DAYS->value)
                   ?->getIntValue()
               ?? 30;
    }


    public function setKeepBackupDays(?int $days): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_KEEP_BACKUP_DAYS->value)
                          ->setIntValue(intValue: $days),
        );
    }


    public function getLastBackup(): ?\DateTime
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_LAST_BACKUP->value)
            ?->getDateValue()
        ;
    }


    public function setLastBackup(\DateTime $lastBackup): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_LAST_BACKUP->value)
                          ->setDateValue(dateValue: $lastBackup),
        );
    }


    public function getMaxWorkers(): ?int
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_MAX_WORKERS->value)
            ?->getIntValue()
        ;
    }


    public function setMaxWorkers(?int $maxWorkers): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_MAX_WORKERS->value)
                          ->setIntValue(intValue: $maxWorkers),
        );
    }


    public function getMaxTasks(): ?int
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_MAX_TASKS->value)
            ?->getIntValue()
        ;
    }


    public function setMaxTasks(?int $maxTasks): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_MAX_TASKS->value)
                          ->setIntValue(intValue: $maxTasks),
        );
    }


    public function getMaxGroups(): ?int
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_MAX_GROUPS->value)
            ?->getIntValue()
        ;
    }


    public function setMaxGroups(?int $maxGroups): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_MAX_GROUPS->value)
                          ->setIntValue(intValue: $maxGroups),
        );
    }


    public function getPrecisionDue(): int
    {
        return $this
                   ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_PRECISION_DUE->value)
                   ?->getIntValue()
               ?? 3;
    }


    public function setPrecisionDue(?int $precisionDue): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_PRECISION_DUE->value)
                          ->setIntValue(intValue: $precisionDue),
        );
    }


    public function doFillTimeLine(): bool
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_FILL_TIME_LINE->value)
            ?->getBoolValue()
            ?: false;
    }


    public function setDoFillTimeLine(?bool $fillTimeLine): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_FILL_TIME_LINE->value)
                          ->setBoolValue(boolValue: $fillTimeLine),
        );
    }


    public function doUseTimer(): bool
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_USE_TIMER->value)
            ?->getBoolValue()
            ?: false;
    }


    public function enableTimer(?bool $useTimer): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_USE_TIMER->value)
                          ->setBoolValue(boolValue: $useTimer),
        );
    }

    public function getDavUser(): ?string
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_DAV_USER->value)
            ?->getStringValue()
        ;
    }

    public function setDavUser(?string $davUser): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_DAV_USER->value)
                          ->setStringValue(stringValue: $davUser),
        );
    }

    public function getDavPassword(): ?string
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_DAV_PASSWORD->value)
            ?->getStringValue()
        ;
    }

    public function setDavPassword(?string $davPassword): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_DAV_PASSWORD->value)
                          ->setStringValue(stringValue: $davPassword),
        );
    }

    public function isMarkdownTransformerActive(): bool
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_MARKDOWN_TRANSFORMER_ACTIVE->value)
            ?->getBoolValue() ?: false;
    }

    public function setMarkdownTransformerActive(bool $active): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_MARKDOWN_TRANSFORMER_ACTIVE->value)
                          ->setBoolValue(boolValue: $active),
        );
    }

    public function backupDelay(): int
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_BACKUP_DELAY->value)
            ?->getIntValue() ?? 2;
    }

    public function setBackupDelay(?int $delay): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_BACKUP_DELAY->value)
                          ->setIntValue(intValue: $delay),
        );
    }

    public function passwordChangeInterval(): int
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_PASSWORD_CHANGE_INTERVAL->value)
            ?->getIntValue() ?? 3;
    }

    public function setPasswordChangeInterval(?int $interval): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_PASSWORD_CHANGE_INTERVAL->value)
                          ->setIntValue(intValue: $interval),
        );
    }

    public function mailContentSecurityNote(): bool
    {
        $row = $this->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_EMAIL_CONTENT_SECURITY_NOTES->value);

        return $row?->getBoolValue() ?? true;
    }

    public function setMailContentSecurityNote(bool $active): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_EMAIL_CONTENT_SECURITY_NOTES->value)
                          ->setBoolValue(boolValue: $active),
        );
    }

    public function mailContentSteps(): bool
    {
        return $this
            ->getRow(key: \DoEveryApp\Util\Registry\Key::KEY_EMAIL_CONTENT_STEPS->value)
            ?->getBoolValue() ?? true;
    }

    public function setMailContentSteps(bool $active): static
    {
        return $this->updateRow(
            registry: $this
                          ->getOrCreateRow(key: \DoEveryApp\Util\Registry\Key::KEY_EMAIL_CONTENT_STEPS->value)
                          ->setBoolValue(boolValue: $active),
        );
    }
}
