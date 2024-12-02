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

    protected int|float|null    $dueCacheValue;

    protected string|float|null $dueCacheUnit     = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Group            $group            = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Worker           $workingOn        = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Worker           $assignee         = null;

    #[\Doctrine\ORM\Mapping\OneToMany(
        targetEntity: \DoEveryApp\Entity\Task\CheckListItem::class,
        mappedBy    : 'task',
    )]
    #[\Doctrine\ORM\Mapping\OrderBy(["position" => "ASC"])]
    protected                   $checkListItems;

    #[\Doctrine\ORM\Mapping\OneToMany(
        targetEntity: \DoEveryApp\Entity\Execution::class,
        mappedBy    : 'task',
    )]
    #[\Doctrine\ORM\Mapping\OrderBy(["id" => "DESC"])]
    protected                   $executions;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string            $name;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'interval_type',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string           $intervalType     = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'interval_value',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: true
    )]
    protected ?int              $intervalValue    = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'is_elapsing_cron_type',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 1,
        ],
    )]
    protected bool              $elapsingCronType = true;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'priority',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: false
    )]
    protected int               $priority         = 100;


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
    protected bool    $active = true;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'note',
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        nullable: true
    )]
    protected ?string $note   = null;


    public function __construct()
    {
        $this->checkListItems = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public static function getRepository(): Task\Repository
    {
        return static::getRepositoryByClassName();
    }


    public function getDueUnit(): ?string
    {
        return $this->dueCacheUnit;
    }


    public function getDueValue(): int|float|null
    {
        if (true === isset($this->dueCacheValue)) {
            return $this->dueCacheValue;
        }
        $lastExecution = $this::getRepository()->getLastExecution($this);
        if (null === $lastExecution) {
            $this->dueCacheValue = null;

            return $this->dueCacheValue;
        }
        if (null === $lastExecution->getDate()) {
            $this->dueCacheValue = null;

            return $this->dueCacheValue;
        }
        if (null === $this->getIntervalType()) {
            $this->dueCacheValue = null;

            return $this->dueCacheValue;
        }
        $due = \Carbon\Carbon::create($lastExecution->getDate());
        $now = \Carbon\Carbon::now();
        switch ($this->getIntervalType()) {
            case \DoEveryApp\Definition\IntervalType::MINUTE->value:
            {
                return $this->calculateDue($due->addMinutes($this->getIntervalValue()));
            }
            case \DoEveryApp\Definition\IntervalType::HOUR->value:
            {
                return $this->calculateDue($due->addHours($this->getIntervalValue()));
            }
            case \DoEveryApp\Definition\IntervalType::DAY->value:
            {
                return $this->calculateDue($due->addDays($this->getIntervalValue()));
            }
            case \DoEveryApp\Definition\IntervalType::MONTH->value:
            {
                return $this->calculateDue($due->addMonths($this->getIntervalValue()));
            }
            case \DoEveryApp\Definition\IntervalType::YEAR->value:
            {
                return $this->calculateDue($due->addYears($this->getIntervalValue()));
            }
        }

        throw new \RuntimeException('WTF?');
    }


    protected function calculateDue(?\Carbon\Carbon $due): int|null|float
    {
        if (null === $due) {
            return null;
        }
        $now  = \Carbon\Carbon::now();
        $diff = $now->diff($due);
        if (0 !== $diff->y) {
            $dueDays = $diff->y + ($diff->m / 12);
            if ($due < $now) {
                $dueDays = $dueDays * -1;
            }
            $this->dueCacheValue = $dueDays;
            $this->dueCacheUnit  = \DoEveryApp\Definition\IntervalType::YEAR->value;

            return $this->dueCacheValue;
        }
        if (0 !== $diff->m) {
            $dueDays = $diff->m + ($diff->d / 30);
            if ($due < $now) {
                $dueDays = $dueDays * -1;
            }
            $this->dueCacheValue = $dueDays;
            $this->dueCacheUnit  = \DoEveryApp\Definition\IntervalType::MONTH->value;

            return $this->dueCacheValue;
        }
        if (0 !== $diff->d) {
            $dueDays = $diff->d + ($diff->h / 24);
            if ($due < $now) {
                $dueDays = $dueDays * -1;
            }
            $this->dueCacheValue = $dueDays;
            $this->dueCacheUnit  = \DoEveryApp\Definition\IntervalType::DAY->value;

            return $this->dueCacheValue;
        }
        if (0 !== $diff->h) {
            $dueDays = $diff->h + ($diff->i / 60);
            if ($due < $now) {
                $dueDays = $dueDays * -1;
            }
            $this->dueCacheValue = $dueDays;
            $this->dueCacheUnit  = \DoEveryApp\Definition\IntervalType::HOUR->value;

            return $this->dueCacheValue;
        }
        if (0 !== $diff->i) {
            $dueDays = $diff->i + ($diff->s / 60);
            if ($due < $now) {
                $dueDays = $dueDays * -1;
            }
            $this->dueCacheValue = $dueDays;
            $this->dueCacheUnit  = \DoEveryApp\Definition\IntervalType::MINUTE->value;

            return $this->dueCacheValue;
        }
        $this->dueCacheValue = null;
        $this->dueCacheUnit  = \DoEveryApp\Definition\IntervalType::MINUTE->value;


        return $this->dueCacheValue;
    }


    /**
     * @return \DoEveryApp\Entity\Task\CheckListItem[]
     */
    public function getCheckListItems(): \Doctrine\Common\Collections\ArrayCollection|\Doctrine\ORM\PersistentCollection|array
    {
        return $this->checkListItems;
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
