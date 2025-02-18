<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Share;

trait SingleIdRoute
{
    public static function getRoute(int $id): string
    {
        $reflection = new \ReflectionClass(objectOrClass: __CLASS__);
        foreach ($reflection->getAttributes(name: \DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            return \str_replace(search: '{id:[0-9]+}', replace: '' . $id, subject: $attribute->getArguments()['path']);
        }

        throw new \RuntimeException(message: 'Could not determine route path');
    }
}
