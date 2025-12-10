<?php

declare(strict_types=1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Group\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : TableNames::TASK_GROUP->value,
    options: Share\DefaultModelOptions::DEFAULT_OPTIONS,
)]
class Group
{
    use Share\DefaultModelTraits;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string  $name;

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
        return Task::getRepository()->getByGroup(group: $this, active: null);
    }

    /**
     * @return Task[]
     */
    public function getActiveTasks(): array
    {
        return Task::getRepository()->getByGroup(group: $this, active: true);
    }

    /**
     * @return Task[]
     */
    public function getInActiveTasks(): array
    {
        return Task::getRepository()->getByGroup(group: $this, active: false);
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
