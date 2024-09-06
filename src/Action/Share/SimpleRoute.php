<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Share;

trait SimpleRoute
{
    public static function getRoute(): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getAttributes(\DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            return $attribute->getArguments()['path'];
        }

        throw new \RuntimeException('Could not determine route path');
    }
}