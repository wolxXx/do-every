<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron\Notification\Item;
interface ItemInterface
{
    public function getContent(): string;
}
