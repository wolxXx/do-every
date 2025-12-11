<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util;


class RegistryTest extends \DoEveryAppTest\TestBase
{

    public function testInstantiation()
    {
        $registry = \DoEveryApp\Util\Registry::getInstance();
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Registry::class, actual: $registry);
    }

    public function testGetSetMaxTasks()
    {
        $maxTasks = 1337;
        $this->assertNull(\DoEveryApp\Util\Registry::getInstance()->getMaxTasks());
        \DoEveryApp\Util\Registry::getInstance()->setMaxTasks(maxTasks: $maxTasks);
        $this->assertSame(expected: $maxTasks, actual: \DoEveryApp\Util\Registry::getInstance()->getMaxTasks());
    }
}

