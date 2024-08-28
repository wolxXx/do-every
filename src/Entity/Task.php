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

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'CASCADE'
    )]
    protected ?Group $group = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'CASCADE'
    )]
    protected ?Worker $workingOn = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'CASCADE'
    )]
    protected ?Worker $assignee = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    public string $name;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'interval_type',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    public ?string $intervalType = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'interval_value',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: true
    )]
    public ?int $intervalValue = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'priority',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: false
    )]
    public int $priority = 100;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'do_notify',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false
    )]
    public bool $notify;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'is_active',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false
    )]
    public bool $active;


    public static function getRepository(): Task\Repository
    {
        return static::getRepositoryByClassName();
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
}
