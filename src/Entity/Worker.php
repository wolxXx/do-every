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
#[\Doctrine\ORM\Mapping\UniqueConstraint(
    name   : 'email',
    columns: ['email']
)]
class Worker
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'worker';

    #[\Doctrine\ORM\Mapping\OneToMany(
        targetEntity: \DoEveryApp\Entity\Task::class,
        mappedBy    : 'workingOn',
    )]
    #[\Doctrine\ORM\Mapping\OrderBy(["name" => "ASC"])]
    protected \Doctrine\Common\Collections\ArrayCollection|\Doctrine\ORM\PersistentCollection $tasksWorkingOn;

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
    protected ?string                                                                         $language = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'email',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $email    = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'password',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $password = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'is_admin',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 0,
        ],
    )]
    protected bool                                                                            $admin    = false;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'do_notify',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 1,
        ],
    )]
    protected bool                                                                            $notify   = true;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'password_reset_token',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string $passwordResetToken = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'password_reset_token_valid_until',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $tokenValidUntil = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'last_login',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $lastLogin = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'notify_login',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 1,
        ],
    )]
    protected bool $notifyLogin = true;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'last_password_change',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $lastPasswordChange          = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_secret',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string    $twoFactorSecret             = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_1',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string    $twoFactorRecoverCode1       = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_1_used_at',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $twoFactorRecoverCode1UsedAt = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_2',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string    $twoFactorRecoverCode2       = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_2_used_at',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $twoFactorRecoverCode2UsedAt = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_3',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string    $twoFactorRecoverCode3       = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_3_used_at',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime $twoFactorRecoverCode3UsedAt = null;

    public function __construct()
    {
        $this->tasksWorkingOn = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public static function getRepository(): Worker\Repository
    {
        return static::getRepositoryByClassName();
    }

    /**
     * @return \DoEveryApp\Entity\Task[]
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setHashedPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function setPassword(?string $password): static
    {
        $this->password = null === $password ? $password : \DoEveryApp\Util\Password::hash($password);

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

    public function getLastPasswordChange(): ?\DateTime
    {
        return $this->lastPasswordChange;
    }

    public function setLastPasswordChange(?\DateTime $lastPasswordChange): static
    {
        $this->lastPasswordChange = $lastPasswordChange;

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

    public function getTwoFactorSecret(): ?string
    {
        return $this->twoFactorSecret;
    }

    public function setTwoFactorSecret(?string $twoFactorSecret): static
    {
        $this->twoFactorSecret = $twoFactorSecret;

        return $this;
    }

    public function getTwoFactorRecoverCode1(): ?string
    {
        return $this->twoFactorRecoverCode1;
    }

    public function setTwoFactorRecoverCode1(?string $twoFactorRecoverCode1): static
    {
        $this->twoFactorRecoverCode1 = $twoFactorRecoverCode1;

        return $this;
    }

    public function getTwoFactorRecoverCode1UsedAt(): ?\DateTime
    {
        return $this->twoFactorRecoverCode1UsedAt;
    }

    public function setTwoFactorRecoverCode1UsedAt(?\DateTime $twoFactorRecoverCode1UsedAt): static
    {
        $this->twoFactorRecoverCode1UsedAt = $twoFactorRecoverCode1UsedAt;

        return $this;
    }

    public function getTwoFactorRecoverCode2(): ?string
    {
        return $this->twoFactorRecoverCode2;
    }

    public function setTwoFactorRecoverCode2(?string $twoFactorRecoverCode2): static
    {
        $this->twoFactorRecoverCode2 = $twoFactorRecoverCode2;

        return $this;
    }

    public function getTwoFactorRecoverCode2UsedAt(): ?\DateTime
    {
        return $this->twoFactorRecoverCode2UsedAt;
    }

    public function setTwoFactorRecoverCode2UsedAt(?\DateTime $twoFactorRecoverCode2UsedAt): static
    {
        $this->twoFactorRecoverCode2UsedAt = $twoFactorRecoverCode2UsedAt;

        return $this;
    }

    public function getTwoFactorRecoverCode3(): ?string
    {
        return $this->twoFactorRecoverCode3;
    }

    public function setTwoFactorRecoverCode3(?string $twoFactorRecoverCode3): static
    {
        $this->twoFactorRecoverCode3 = $twoFactorRecoverCode3;

        return $this;
    }

    public function getTwoFactorRecoverCode3UsedAt(): ?\DateTime
    {
        return $this->twoFactorRecoverCode3UsedAt;
    }

    public function setTwoFactorRecoverCode3UsedAt(?\DateTime $twoFactorRecoverCode3UsedAt): static
    {
        $this->twoFactorRecoverCode3UsedAt = $twoFactorRecoverCode3UsedAt;

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
