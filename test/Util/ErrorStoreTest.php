<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util;


class ErrorStoreTest extends \DoEveryAppTest\TestBase
{
    public function testInstantiation()
    {
        $this->assertSame(expected: \get_class(object: new \DoEveryApp\Util\ErrorStore()), actual: \DoEveryApp\Util\ErrorStore::class);
    }
}