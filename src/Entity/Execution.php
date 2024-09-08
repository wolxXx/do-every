<?php

declare(strict_types=1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Execution\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]

class Execution
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'task_execution';


    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Task::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected Task $task;



    #[\Doctrine\ORM\Mapping\OneToMany(
        targetEntity: \DoEveryApp\Entity\Execution\CheckListItem::class,
        mappedBy    : 'execution',
    )]
    #[\Doctrine\ORM\Mapping\OrderBy(["position" => "ASC"])]

    protected         $checkListItems;


    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?Worker $worker   = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'date',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: false
    )]
    protected \DateTime  $date;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'note',
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        nullable: true
    )]
    protected ?string    $note     = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'duration',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: true
    )]
    protected ?int       $duration = null;


    public function __construct()
    {
        $this->checkListItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public static function getRepository(): Execution\Repository
    {
        return static::getRepositoryByClassName();
    }


    /**
     * @return \DoEveryApp\Entity\Execution\CheckListItem[]
     */
    public function getCheckListItems(): \Doctrine\Common\Collections\ArrayCollection|\Doctrine\ORM\PersistentCollection|array
    {
        return $this->checkListItems;
    }


    public function getTask(): Task
    {
        return $this->task;
    }


    public function setTask(Task $task): static
    {
        $this->task = $task;

        return $this;
    }


    public function getWorker(): ?Worker
    {
        return $this->worker;
    }


    public function setWorker(?Worker $worker): static
    {
        $this->worker = $worker;

        return $this;
    }


    public function getDate(): \DateTime
    {
        return $this->date;
    }


    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

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


    public function getDuration(): ?int
    {
        return $this->duration;
    }


    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
