<?php

declare(strict_types = 1);

namespace DoEveryApp\Entity\Share;

class DefaultModelOptions
{
    public const array DEFAULT_OPTIONS = [
        'charset' => 'utf8',
        'collate' => 'utf8_general_ci',
        'engine'  => 'InnoDB',
    ];
}