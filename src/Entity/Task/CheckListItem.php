<?php


declare(strict_types=1);

namespace DoEveryApp\Entity\Task;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: CheckListItem\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]

class CheckListItem
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'task_check_list_item';


    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \DoEveryApp\Entity\Task::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected \DoEveryApp\Entity\Task $task;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'position',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: false,
        options : [
            "default" => 0,
        ],
    )]
    protected int                     $position = 0;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string  $name;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'note',
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        nullable: true
    )]
    protected ?string $note = null;


    public static function getRepository(): CheckListItem\Repository
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


    public function getPosition(): int
    {
        return $this->position;
    }


    public function setPosition(int $position): static
    {
        $this->position = $position;

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


    public function getNote(): ?string
    {
        return $this->note;
    }


    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }
}
