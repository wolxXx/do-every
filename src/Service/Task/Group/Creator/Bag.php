<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task\Group\Creator;

class Bag
{
    protected string  $name;

    protected ?string $color = null;


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