<?php

declare(strict_types = 1);

namespace DoEveryApp\Entity;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Worker\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : TableNames::WORKER->value,
    options: Share\DefaultModelOptions::DEFAULT_OPTIONS,
)]
#[\Doctrine\ORM\Mapping\UniqueConstraint(
    name   : 'email',
    columns: [
        'email',
    ]
)]
class Worker
{
    use Share\DefaultModelTraits;

    #[\Doctrine\ORM\Mapping\OneToMany(
        targetEntity: Task::class,
        mappedBy    : 'workingOn',
    )]
    #[\Doctrine\ORM\Mapping\OrderBy(["name" => "ASC"])]
    protected \Doctrine\Common\Collections\ArrayCollection|\Doctrine\ORM\PersistentCollection $tasksWorkingOn;

    #[\Doctrine\ORM\Mapping\OneToMany(
        targetEntity: Worker\Credential::class,
        mappedBy    : 'worker',
    )]
    #[\Doctrine\ORM\Mapping\OrderBy(["id" => "DESC"])]
    protected \Doctrine\Common\Collections\ArrayCollection|\Doctrine\ORM\PersistentCollection $credentials;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string                                                                          $name;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'language',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $language                    = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'email',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $email                       = null;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'is_admin',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 0,
        ],
    )]
    protected bool                                                                            $admin                       = false;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'do_notify',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 1,
        ],
    )]
    protected bool                                                                            $notify                      = true;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'password_reset_token',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $passwordResetToken          = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'password_reset_token_valid_until',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                                                      $tokenValidUntil             = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'last_login',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                                                      $lastLogin                   = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'notify_login',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 1,
        ],
    )]
    protected bool                                                                            $notifyLogin                 = true;


    public function __construct()
    {
        $this->credentials    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tasksWorkingOn = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public static function getRepository(): Worker\Repository
    {
        return static::getRepositoryByClassName();
    }

    public function getPasswordCredential(): ?Worker\Credential
    {
        return Worker\Credential::getRepository()->findPasswordForWorker($this);
    }

    public function getPasskeyCredential(): ?Worker\Credential
    {
        return Worker\Credential::getRepository()->findPasskeyForWorker($this);
    }

    public function getLastPasswordChange(): ?\DateTime
    {
        return $this->getPasswordCredential()?->getLastPasswordChange();
    }

    public function getTwoFactorSecret():?string
    {
        return $this->getPasswordCredential()?->getTwoFactorSecret();
    }

    /**
     * @return Task[]
     */
    public function getTasksWorkingOn(): \Doctrine\Common\Collections\ArrayCollection|\Doctrine\ORM\PersistentCollection|array
    {
        return $this->tasksWorkingOn;
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

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTime $lastLogin): static
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken): static
    {
        $this->passwordResetToken = $passwordResetToken;

        return $this;
    }

    public function getTokenValidUntil(): ?\DateTime
    {
        return $this->tokenValidUntil;
    }

    public function setTokenValidUntil(?\DateTime $tokenValidUntil): static
    {
        $this->tokenValidUntil = $tokenValidUntil;

        return $this;
    }

    public function doNotifyLogin(): bool
    {
        return $this->notifyLogin;
    }

    public function setNotifyLogin(bool $notifyLogin): static
    {
        $this->notifyLogin = $notifyLogin;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): static
    {
        $this->language = $language;

        return $this;
    }
}
