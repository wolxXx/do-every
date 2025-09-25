<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron\Notification\Item;

class PasswordChange implements ItemInterface
{
    public function __construct(
        public ?\DateTime $lastChange
    ) {
    }

    #[\Override]
    public function getContent(): string
    {
        $message = 'Du solltest dein Passwort ändern.' . \PHP_EOL;
        if (null !== $this->lastChange) {
            $message .= 'Das letzte mal war am ' . $this->lastChange->format('d.m.Y');
        }

        return $message;
    }
}

