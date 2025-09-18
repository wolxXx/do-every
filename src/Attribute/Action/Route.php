<?php

declare(strict_types=1);

namespace DoEveryApp\Attribute\Action;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Route
{
    public array $methods;

    public function __construct(
        public string $path,
        array         $methods = [\Fig\Http\Message\RequestMethodInterface::METHOD_GET],
        public bool   $authRequired = true,
    ) {
        $this->methods = $methods;
    }
}
