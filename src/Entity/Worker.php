<?php

declare(strict_types=1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Worker\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]

class Worker
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'worker';

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    public string  $name;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'email',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    public ?string $email    = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'password',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    public ?string $password = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'is_admin',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false
    )]
    public bool    $admin;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'do_notify',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false
    )]
    public bool    $notify;


    public static function getRepository(): Worker\Repository
    {
        return static::getRepositoryByClassName();
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


    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }


    public function isAdmin(): bool
    {
        return $this->admin;
    }


    public function setIsAdmin(bool $admin): static
    {
        $this->admin = $admin;

        return $this;
    }


    public function doNotify(): bool
    {
        return $this->notify;
    }


    public function enableNotifications(bool $notify): static
    {
        $this->notify = $notify;

        return $this;
    }
}
