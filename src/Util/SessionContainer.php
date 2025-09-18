<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class SessionContainer
{
    private string $name;


    public function __construct(string $name)
    {
        $this->name = $name;
        switch (\session_status()) {
            case PHP_SESSION_DISABLED:
                {
                    return;
                }
            case \PHP_SESSION_NONE:
                {
                    \session_start();
                    break;
                }
            case \PHP_SESSION_ACTIVE:
                {
                    // all good
                    break;
                }
        }
        if (null !== $_SESSION && false === \array_key_exists(key: $this->getName(), array: $_SESSION)) {
            $_SESSION[$name] = [];
        }
    }


    public function offsetExists(string $key): bool
    {
        return null !== $_SESSION && true === \array_key_exists(key: $this->getName(), array: $_SESSION) && true === \array_key_exists(key: $key, array: $_SESSION[$this->getName()]);
    }


    public function offsetGet(string $key, mixed $default = null): mixed
    {
        if (false === $this->offsetExists(key: $key)) {
            return $default;
        }

        return $_SESSION[$this->getName()][$key];
    }


    public function offsetSet(string $key, mixed $data = null): static
    {
        $_SESSION[$this->getName()][$key] = $data;

        return $this;
    }


    public function offsetUnset(string $key): static
    {
        unset($_SESSION[$this->getName()][$key]);

        return $this;
    }


    public function clear(): static
    {
        unset($_SESSION[$this->getName()]);

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
}
