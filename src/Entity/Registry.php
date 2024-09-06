<?php

declare(strict_types=1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Registry\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name: self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine' => 'InnoDB',
    ],
)]
#[\Doctrine\ORM\Mapping\UniqueConstraint(
    name: 'key_name',
    columns: ['key_name']
)]
class Registry
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'registry';

    #[\Doctrine\ORM\Mapping\Column(
        name: 'key_name',
        type: \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string $key;

    #[\Doctrine\ORM\Mapping\Column(
        name: 'read_only',
        type: \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options: [
            'default' => 0
        ]
    )]
    protected bool $readOnly = false;

    #[\Doctrine\ORM\Mapping\Column(
        name: 'visible',
        type: \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options: [
            'default' => 1
        ]
    )]
    protected bool $visible = false;

    #[\Doctrine\ORM\Mapping\Column(
        name: 'int_value',
        type: \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: true
    )]
    protected ?int $intValue = null;

    #[\Doctrine\ORM\Mapping\Column(
        name: 'bool_value',
        type: \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: true
    )]
    protected ?bool $boolValue = null;

    #[\Doctrine\ORM\Mapping\Column(
        name: 'string_value',
        type: \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string $stringValue = null;

    #[\Doctrine\ORM\Mapping\Column(
        name: 'date_value',
        type: \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $dateValue = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Execution::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'execution_reference_set_null',
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Execution $executionSetNull = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Execution::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'execution_reference_cascade',
        nullable: true,
        onDelete: 'CASCADE'
    )]
    protected ?Execution $executionCascade = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Execution::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'execution_reference_restrict',
        nullable: true,
        onDelete: 'RESTRICT'
    )]
    protected ?Execution $executionRestrict = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'group_reference_set_null',
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Group $groupSetNull = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'group_reference_cascade',
        nullable: true,
        onDelete: 'CASCADE'
    )]
    protected ?Group $groupCascade = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Group::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'group_reference_restrict',
        nullable: true,
        onDelete: 'RESTRICT'
    )]
    protected ?Group $groupRestrict = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Task::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'task_reference_set_null',
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Task $taskSetNull = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Task::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'task_reference_cascade',
        nullable: true,
        onDelete: 'CASCADE'
    )]
    protected ?Task $taskCascade = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Task::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'task_reference_restrict',
        nullable: true,
        onDelete: 'RESTRICT'
    )]
    protected ?Task $taskRestrict = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'worker_reference_set_null',
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Worker $workerSetNull = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'worker_reference_cascade',
        nullable: true,
        onDelete: 'CASCADE'
    )]
    protected ?Worker $workerCascade = null;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        name: 'worker_reference_restrict',
        nullable: true,
        onDelete: 'RESTRICT'
    )]
    protected ?Worker $workerRestrict = null;


    public static function getRepository(): Registry\Repository
    {
        return static::getRepositoryByClassName();
    }


    public function getKey(): string
    {
        return $this->key;
    }


    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }


    public function getIntValue(): ?int
    {
        return $this->intValue;
    }


    public function setIntValue(?int $intValue): static
    {
        $this->intValue = $intValue;

        return $this;
    }


    public function getBoolValue(): ?bool
    {
        return $this->boolValue;
    }


    public function setBoolValue(?bool $boolValue): static
    {
        $this->boolValue = $boolValue;

        return $this;
    }


    public function getStringValue(): ?string
    {
        return $this->stringValue;
    }


    public function setStringValue(?string $stringValue): static
    {
        $this->stringValue = $stringValue;

        return $this;
    }


    public function getDateValue(): ?\DateTime
    {
        return $this->dateValue;
    }


    public function setDateValue(?\DateTime $dateValue): static
    {
        $this->dateValue = $dateValue;

        return $this;
    }


    public function getExecutionSetNull(): ?Execution
    {
        return $this->executionSetNull;
    }


    public function setExecutionSetNull(?Execution $executionSetNull): static
    {
        $this->executionSetNull = $executionSetNull;

        return $this;
    }


    public function getExecutionCascade(): ?Execution
    {
        return $this->executionCascade;
    }


    public function setExecutionCascade(?Execution $executionCascade): static
    {
        $this->executionCascade = $executionCascade;

        return $this;
    }


    public function getGroupSetNull(): ?Group
    {
        return $this->groupSetNull;
    }


    public function setGroupSetNull(?Group $groupSetNull): static
    {
        $this->groupSetNull = $groupSetNull;

        return $this;
    }


    public function getGroupCascade(): ?Group
    {
        return $this->groupCascade;
    }


    public function setGroupCascade(?Group $groupCascade): static
    {
        $this->groupCascade = $groupCascade;

        return $this;
    }


    public function getTaskSetNull(): ?Task
    {
        return $this->taskSetNull;
    }


    public function setTaskSetNull(?Task $taskSetNull): static
    {
        $this->taskSetNull = $taskSetNull;

        return $this;
    }


    public function getTaskCascade(): ?Task
    {
        return $this->taskCascade;
    }


    public function setTaskCascade(?Task $taskCascade): static
    {
        $this->taskCascade = $taskCascade;

        return $this;
    }


    public function getWorkerSetNull(): ?Worker
    {
        return $this->workerSetNull;
    }


    public function setWorkerSetNull(?Worker $workerSetNull): static
    {
        $this->workerSetNull = $workerSetNull;

        return $this;
    }


    public function getWorkerCascade(): ?Worker
    {
        return $this->workerCascade;
    }


    public function setWorkerCascade(?Worker $workerCascade): static
    {
        $this->workerCascade = $workerCascade;

        return $this;
    }


    public function getExecutionRestrict(): ?Execution
    {
        return $this->executionRestrict;
    }


    public function setExecutionRestrict(?Execution $executionRestrict): static
    {
        $this->executionRestrict = $executionRestrict;

        return $this;
    }


    public function getGroupRestrict(): ?Group
    {
        return $this->groupRestrict;
    }


    public function setGroupRestrict(?Group $groupRestrict): static
    {
        $this->groupRestrict = $groupRestrict;

        return $this;
    }


    public function getTaskRestrict(): ?Task
    {
        return $this->taskRestrict;
    }


    public function setTaskRestrict(?Task $taskRestrict): static
    {
        $this->taskRestrict = $taskRestrict;

        return $this;
    }


    public function getWorkerRestrict(): ?Worker
    {
        return $this->workerRestrict;
    }


    public function setWorkerRestrict(?Worker $workerRestrict): static
    {
        $this->workerRestrict = $workerRestrict;

        return $this;
    }

    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    public function setReadOnly(bool $readOnly): static
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }
}
