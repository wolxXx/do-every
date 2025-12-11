<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Task\Timer;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Section\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : \DoEveryApp\Entity\TableNames::TASK_TIMER_SECTION->value,
    options: \DoEveryApp\Entity\Share\DefaultModelOptions::DEFAULT_OPTIONS,
)]

class Section
{
    use \DoEveryApp\Entity\Share\DefaultModelTraits;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \DoEveryApp\Entity\Task\Timer::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected \DoEveryApp\Entity\Task\Timer $timer;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'start',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: false
    )]
    protected \DateTime $start;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'end',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $end = null;

    public static function getRepository(): Section\Repository
    {
        return static::getRepositoryByClassName();
    }

    public function getTimer(): \DoEveryApp\Entity\Task\Timer
    {
        return $this->timer;
    }

    public function setTimer(\DoEveryApp\Entity\Task\Timer $timer): static
    {
        $this->timer = $timer;

        return $this;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }

    public function setEnd(?\DateTime $end): static
    {
        $this->end = $end;

        return $this;
    }
}
