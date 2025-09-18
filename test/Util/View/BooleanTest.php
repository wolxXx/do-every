<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class BooleanTest extends \DoEveryAppTest\TestBase
{
    public function testGetTrue()
    {
        $this->assertSame(expected: 'ja', actual: \DoEveryApp\Util\View\Boolean::get(value: true));
    }


    public function testGetFalse()
    {
        $this->assertSame(expected: 'nein', actual: \DoEveryApp\Util\View\Boolean::get(value: false));
    }

    public function testGetFailsWithOtherThanBoolean()
    {
        $this->expectException(exception: \TypeError::class);
        \DoEveryApp\Util\View\Boolean::get(value: 'asdf');
    }
}