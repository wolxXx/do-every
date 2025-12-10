<?php

declare(strict_types=1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Session\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : TableNames::SESSION->value,
    options: Share\DefaultModelOptions::DEFAULT_OPTIONS,
)]
class Session
{
    use Share\Id;
    use Share\Repository;

    #[\Doctrine\ORM\Mapping\Column(
        type: \Doctrine\DBAL\Types\Types::STRING
    )]
    protected string $name;

    #[\Doctrine\ORM\Mapping\Column(
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        nullable: false
    )]
    protected string $content;

    #[\Doctrine\ORM\Mapping\Column(
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string $expires;

    public static function getRepository(): Session\Repository
    {
        return static::getRepositoryByClassName();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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

    public function getExpires(): string
    {
        return $this->expires;
    }

    public function setExpires(string $expires): static
    {
        $this->expires = $expires;

        return $this;
    }
}
