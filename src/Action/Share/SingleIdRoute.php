<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Share;

trait SingleIdRoute
{
    public static function getRoute(int $id): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getAttributes(\DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            return \str_replace('{id:[0-9]+}', '' . $id, $attribute->getArguments()['path']);
        }
    }
}