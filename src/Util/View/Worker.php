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

}
