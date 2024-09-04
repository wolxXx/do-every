<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class Worker
{
    public static function get(?\DoEveryApp\Entity\Worker $worker): string
    {
        if (null === $worker) {
            return '-';
        }

        return \DoEveryApp\Util\View\Escaper::escape($worker->getName());
    }


    public static function isTimeForPasswortChange(\DoEveryApp\Entity\Worker $worker): bool
    {
        if (null === $worker->getPassword()) {
            return false;
        }
        if (null === $worker->getLastPasswordChange()) {
            return true;
        }
        $due = \Carbon\Carbon::create($worker->getLastPasswordChange())->addMonths(3);

        return \Carbon\Carbon::now()->greaterThan($due);
    }
}
