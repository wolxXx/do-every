<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Task\Timer;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Section\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]

class Section
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'task_timer_section';

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \DoEveryApp\Entity\Task\Timer::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected \DoEveryApp\Entity\Task\Timer $task;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'start',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: false
    )]
    protected \DateTime $start;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'end',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: false
    )]
    protected \DateTime $end;

    public static function getRepository(): Timer\Repository
    {
        return static::getRepositoryByClassName();
    }
}
