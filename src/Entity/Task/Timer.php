<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Task;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Timer\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]

class Timer
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'task_timer';

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \DoEveryApp\Entity\Task::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected \DoEveryApp\Entity\Task $task;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \DoEveryApp\Entity\Worker::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected \DoEveryApp\Entity\Worker $worker;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'duration',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: true
    )]
    protected ?int $duration = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'stopped',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options: ['default' => false]
    )]
    protected bool $stopped = false;

    public static function getRepository(): Timer\Repository
    {
        return static::getRepositoryByClassName();
    }

    public function getTask(): \DoEveryApp\Entity\Task
    {
        return $this->task;
    }

    public function setTask(\DoEveryApp\Entity\Task $task): static
    {
        $this->task = $task;

        return $this;
    }

    public function getWorker(): \DoEveryApp\Entity\Worker
    {
        return $this->worker;
    }

    public function setWorker(\DoEveryApp\Entity\Worker $worker): static
    {
        $this->worker = $worker;

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

    public function isStopped(): bool
    {
        return $this->stopped;
    }

    public function setStopped(bool $stopped): static
    {
        $this->stopped = $stopped;

        return $this;
    }
}
