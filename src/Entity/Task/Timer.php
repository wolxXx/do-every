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


    public static function getRepository(): Timer\Repository
    {
        return static::getRepositoryByClassName();
    }
}
