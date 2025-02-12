<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class BufferContainer
{
    private array $bufferContents = [];

    private int   $counter        = 0;

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

        $result               = \implode(' ', $this->bufferContents);
        $this->bufferContents = [];

        return $result;
    }

    public function set($registration, $content): static
    {
        $this->bufferContents[$registration] = $content;

        return $this;
    }
}
