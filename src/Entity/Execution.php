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


    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: Worker::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'CASCADE'
    )]
    protected ?Worker $worker   = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'date',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: false
    )]
    public \DateTime  $date;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'note',
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        nullable: true
    )]
    public ?string    $note     = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'duration',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: true
    )]
    public ?int       $duration = null;


    public static function getRepository(): Execution\Repository
    {
        return static::getRepositoryByClassName();
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
