<?php

declare(strict_types=1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Notification\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]

class Notification
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'task_notification';


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
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected Worker $worker;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'date',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: false
    )]
    protected \DateTime  $date;


    public static function getRepository(): Notification\Repository
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


    public function getWorker(): Worker
    {
        return $this->worker;
    }


    public function setWorker(Worker $worker): static
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
}
