<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Session
{
    /**
     * @var SessionContainer[]
     */
    private static array $containers = [];

    private static bool $hasSetSaveHandler = false;

    private string       $namespace;

    public const string NAMESPACE_APPLICATION = 'application';
    public const string NAMESPACE_AUTH = 'auth';


    public static function Factory(string $namespace): static
    {
        if (false === static::$hasSetSaveHandler) {
            \session_set_save_handler(new SessionSaveHandler(DependencyContainer::getInstance()->getEntityManager()));
            static::$hasSetSaveHandler = true;
        }
        $instance            = new static();
        $instance->namespace = $namespace;
        if (false === \array_key_exists($namespace, static::$containers)) {
            static::$containers[$namespace] = new SessionContainer($namespace);
        }

        return $instance;
    }


    public function has(string $what): bool
    {
        return static::$containers[$this->namespace]->offsetExists($what);
    }


    public function get(string $what, $default = null)
    {
        if (false === $this->has($what)) {
            return $default;
        }
        $stored = static::$containers[$this->namespace]->offsetGet($what);
        if (null === $stored) {
            return $default;
        }

        return $stored;
    }


    public function write(string $what, $data): self
    {
        static::$containers[$this->namespace]->offsetSet($what, $data);

        return $this;
    }


    public function clear(string $what): self
    {
        static::$containers[$this->namespace]->offsetUnset($what);

        return $this;
    }


    public function reset(): self
    {
        static::$containers[$this->namespace]->clear();

        return $this;
    }
}
