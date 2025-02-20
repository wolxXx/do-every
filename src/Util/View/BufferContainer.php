<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class BufferContainer
{
    /**
     * @var array<string, string> Array to store buffer contents with registration keys and their content values.
     */
    private array $bufferContents = [];

    private int $counter = 0;

    public function next(): int
    {
        return $this->counter++;
    }

    public function __toString(): string
    {
        return $this->get();
    }

    public function get(): string
    {
        \Revolt\EventLoop::run();

        $result = \implode(separator: ' ', array: $this->bufferContents);
        $this->bufferContents = [];
        $this->counter = 0;

        return $result;
    }

    public function set(int|string $registration, string $content = ''): static
    {
        $this->bufferContents[''.$registration] = $content;

        return $this;
    }
}
