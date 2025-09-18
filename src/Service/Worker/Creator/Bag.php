<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Worker\Creator;

class Bag
{
    protected string  $name;

    protected bool    $admin        = false;

    protected ?string $email        = null;

    protected ?string $password     = null;

    protected bool    $notify       = false;

    protected bool    $notifyLogins = false;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
        $this->password = null === $password ? $password : \DoEveryApp\Util\Password::hash(password: $password);

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

    public function doNotifyLogins(): bool
    {
        return $this->notifyLogins;
    }

    public function enableLoginNotifications(bool $notifyLogins): static
    {
        $this->notifyLogins = $notifyLogins;

        return $this;
    }
}
