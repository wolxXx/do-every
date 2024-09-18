<?php

declare(strict_types=1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Group\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]
class Group
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'task_group';

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string $name;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'color',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string $color = null;


    public static function getRepository(): Group\Repository
    {
        return static::getRepositoryByClassName();
    }


    /**
     * @return Task[]
     */
    public function getTasks(): array
    {
        return Task::getRepository()
            ->getByGroup($this, null)
            ;
    }

    /**
     * @return Task[]
     */
    public function getActiveTasks(): array
    {
        return Task::getRepository()
            ->getByGroup($this, true)
            ;
    }

    /**
     * @return Task[]
     */
    public function getInActiveTasks(): array
    {
        return Task::getRepository()
            ->getByGroup($this, false)
            ;
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;
        
        return $this;
    }
}
