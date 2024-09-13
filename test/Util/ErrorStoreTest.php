<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util;


class ErrorStoreTest extends \DoEveryAppTest\TestBase
{
    public function testInstantiation()
    {
        $this->assertSame(\get_class((new \DoEveryApp\Util\ErrorStore())), \DoEveryApp\Util\ErrorStore::class);
    }
}