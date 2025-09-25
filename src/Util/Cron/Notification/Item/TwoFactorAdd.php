<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron\Notification\Item;

class TwoFactorAdd implements ItemInterface
{
    #[\Override]
    public function getContent(): string
    {
        return 'Du solltest einen zweiten Faktor für deinen Login einrichten.';
    }
}

