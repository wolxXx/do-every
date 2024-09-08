<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron;

class BackupRotation
{
    public function __construct()
    {
        $now     = \Carbon\Carbon::now();
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug('backup rotation');
    }
}