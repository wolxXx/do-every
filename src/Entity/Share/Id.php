<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Share;

trait Id
{
    #[\Doctrine\ORM\Mapping\Id]
    #[\Doctrine\ORM\Mapping\Column(
        type: \Doctrine\DBAL\Types\Types::INTEGER
    )]
    #[\Doctrine\ORM\Mapping\GeneratedValue]
    protected int $id;

    public function getId(): ?int
    {
        if (false === isset($this->id)) {
            return null;
        }

        return $this->id;
    }

    public function hasId(): bool
    {
        return true === isset($this->id) && null !== $this->getId();
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }
}
