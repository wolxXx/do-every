<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class ErrorStore
{
    protected array $errors = [];

    public function hasError(string $key): bool
    {
        return \array_key_exists($key, $this->errors) && 0 !== count($this->errors[$key]);
    }

    public function getErrors(string $key): array
    {
        if (false === $this->hasError($key)) {
            return [];
        }
        return (array)$this->errors[$key];
    }

    public function addError(string $key, string $message): static
    {
        if (false === \array_key_exists($key, $this->errors)) {
            $this->errors[$key] = [];
        }
        $this->errors[$key][] = $message;
        return $this;
    }

    public function getAllErrors(): array
    {
        return $this->errors;
    }
}