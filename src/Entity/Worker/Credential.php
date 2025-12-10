<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Worker;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Credential\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : \DoEveryApp\Entity\TableNames::WORKER_CREDENTIAL->value,
    options: \DoEveryApp\Entity\Share\DefaultModelOptions::DEFAULT_OPTIONS,
)]

class Credential
{
    use \DoEveryApp\Entity\Share\DefaultModelTraits;

    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \DoEveryApp\Entity\Worker::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected \DoEveryApp\Entity\Worker $worker;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'last_password_change',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                                                      $lastPasswordChange          = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_secret',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $twoFactorSecret             = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_1',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $twoFactorRecoverCode1       = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_1_used_at',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                                                      $twoFactorRecoverCode1UsedAt = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_2',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $twoFactorRecoverCode2       = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_2_used_at',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                                                      $twoFactorRecoverCode2UsedAt = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_3',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $twoFactorRecoverCode3       = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'two_factor_recover_code_3_used_at',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected ?\DateTime                                                                      $twoFactorRecoverCode3UsedAt = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'password',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $password                    = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'passkey_secret',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: true
    )]
    protected ?string                                                                         $passkeySecret                    = null;

    public static function getRepository(): Credential\Repository
    {
        return static::getRepositoryByClassName();
    }


    public function getPasskeySecret(): ?string
    {
        return $this->passkeySecret;
    }

    public function setPasskeySecret(?string $passkeySecret): static
    {
        $this->passkeySecret = $passkeySecret;

        return $this;
    }

    public function getWorker(): \DoEveryApp\Entity\Worker
    {
        return $this->worker;
    }

    public function setWorker(\DoEveryApp\Entity\Worker $worker): static
    {
        $this->worker = $worker;

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
        $this->password = null === $password ? $password : \DoEveryApp\Util\Password::hash(password: $password);

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
}