<?php

declare(strict_types=1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Task\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]
class Task
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'task';

    protected ?int $dueCache;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Group $group = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Worker $workingOn = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Worker $assignee = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string $name;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'interval_type',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string $intervalType = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'interval_value',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: true
    )]
    protected ?int $intervalValue = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'is_elapsing_cron_type',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 1,
        ],
    )]
    protected bool $elapsingCronType = true;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'priority',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: false
    )]
    protected int $priority = 100;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'do_notify',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 0,
        ],
    )]
    protected bool $notify = false;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'is_active',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 1,
        ],
    )]
    protected bool $active = true;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'note',
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        nullable: true
    )]
    protected ?string $note = null;


    public static function getRepository(): Task\Repository
    {
        return static::getRepositoryByClassName();
    }


    public function getDueValue(): ?int
    {
        if (true === isset($this->dueCache)) {
            return $this->dueCache;
        }
        $lastExecution = $this::getRepository()->getLastExecution($this);
        if (null === $lastExecution) {
            $this->dueCache = null;

            return $this->dueCache;
        }
        if (null === $lastExecution->getDate()) {
            $this->dueCache = null;

            return $this->dueCache;
        }
        if (null === $this->getIntervalType()) {
            $this->dueCache = null;

            return $this->dueCache;
        }
        $due = \Carbon\Carbon::create($lastExecution->getDate());
        $now = \Carbon\Carbon::now();
        switch ($this->getIntervalType()) {
            case \DoEveryApp\Definition\IntervalType::MINUTE->value:
            {
                $due
                    ->second(0)
                ;
                $now
                    ->second(0)
                ;
                $due->addMinutes($this->getIntervalValue());
                $diff    = $now->diff($due);
                $dueDays = ($diff->y * 365 * 30 * 24 * 60) + ($diff->m * 30 * 24 * 60) + ($diff->d * 24 * 60) +  ($diff->h * 60)  +  $diff->i + 1;
                if ($due < $now) {
                    $dueDays = $dueDays * -1;
                }
                $this->dueCache = $dueDays;

                return $this->dueCache;
            }
            case \DoEveryApp\Definition\IntervalType::HOUR->value:
            {
                $due
                    ->minute(0)
                    ->second(0)
                ;
                $now
                    ->minute(0)
                    ->second(0)
                ;
                $due->addHours($this->getIntervalValue());
                $diff    = $now->diff($due);

                $dueDays = ($diff->y * 365 * 30 * 24) + ($diff->m * 30 * 24) + ($diff->d * 24) +  $diff->h + 1;
                if ($due < $now) {
                    $dueDays = $dueDays * -1;
                }
                $this->dueCache = $dueDays;

                return $this->dueCache;
            }
            case \DoEveryApp\Definition\IntervalType::DAY->value:
            {
                $due
                    ->second(0)
                    ->minute(0)
                    ->hour(0)
                ;
                $now
                    ->second(0)
                    ->minute(0)
                    ->hour(0)
                ;
                $due->addDays($this->getIntervalValue());
                $diff    = $now->diff($due);
                $dueDays = $diff->d;
                if ($due < $now) {
                    $dueDays = $dueDays * -1;
                }
                $this->dueCache = $dueDays;

                return $this->dueCache;
            }
            case \DoEveryApp\Definition\IntervalType::MONTH->value:
            {
                $due
                    ->second(0)
                    ->minute(0)
                    ->hour(1)
                    ->day(1)
                ;
                $now
                    ->second(0)
                    ->minute(0)
                    ->hour(0)
                    ->day(1)
                ;
                $due->addMonths($this->getIntervalValue());
               $diff    = $now->diff($due);
                $dueDays = (($diff->m + ($diff->y * 12)) * 30) + $diff->d;
                if ($due < $now) {
                    $dueDays = $dueDays * -1;
                }
                $this->dueCache = $dueDays;

                return $this->dueCache;
            }
            case \DoEveryApp\Definition\IntervalType::YEAR->value:
            {
                $due
                    ->second(0)
                    ->minute(0)
                    ->hour(1)
                    ->day(1)
                ;
                $now
                    ->second(0)
                    ->minute(0)
                    ->hour(0)
                    ->day(1)
                ;
                $due->addYears($this->getIntervalValue());
                $diff    = $now->diff($due);
                $dueDays = (($diff->m + ($diff->y * 12)) * 30) + $diff->d;
                if ($due < $now) {
                    $dueDays = $dueDays * -1;
                }
                $this->dueCache = $dueDays;

                return $this->dueCache;
            }
        }

        throw new \RuntimeException('WTF?');
    }


    /**
     * @return Execution[]
     */
    public function getExecutions(): array
    {
        return Execution::getRepository()->findIndexed($this);
    }


    public function getExecutionDuration(): int
    {
        return Execution::getRepository()->findIndexed($this);
    }


    public function getGroup(): ?Group
    {
        return $this->group;
    }


    public function setGroup(?Group $group): static
    {
        $this->group = $group;

        return $this;
    }


    public function getWorkingOn(): ?Worker
    {
        return $this->workingOn;
    }


    public function setWorkingOn(?Worker $workingOn): static
    {
        $this->workingOn = $workingOn;

        return $this;
    }


    public function getAssignee(): ?Worker
    {
        return $this->assignee;
    }


    public function setAssignee(?Worker $assignee): static
    {
        $this->assignee = $assignee;

        return $this;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function getIntervalType(): ?string
    {
        return $this->intervalType;
    }


    public function setIntervalType(?string $intervalType): static
    {
        $this->intervalType = $intervalType;

        return $this;
    }


    public function getIntervalValue(): ?int
    {
        return $this->intervalValue;
    }


    public function setIntervalValue(?int $intervalValue): static
    {
        $this->intervalValue = $intervalValue;

        return $this;
    }


    public function getPriority(): int
    {
        return $this->priority;
    }


    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }


    public function isNotify(): bool
    {
        return $this->notify;
    }


    public function setNotify(bool $notify): static
    {
        $this->notify = $notify;

        return $this;
    }


    public function isActive(): bool
    {
        return $this->active;
    }


    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }


    public function getNote(): ?string
    {
        return $this->note;
    }


    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }


    public function isElapsingCronType(): bool
    {
        return $this->elapsingCronType;
    }


    public function setElapsingCronType(bool $elapsingCronType): static
    {
        $this->elapsingCronType = $elapsingCronType;

        return $this;
    }
}
