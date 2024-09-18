<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class BooleanTest extends \DoEveryAppTest\TestBase
{
    public function testGetTrue()
    {
        $this->assertSame('ja', \DoEveryApp\Util\View\Boolean::get(true));
    }


    public function testGetFalse()
    {
        $this->assertSame('nein', \DoEveryApp\Util\View\Boolean::get(false));
    }

    public function testGetFailsWithOtherThanBoolean()
    {
        $this->expectException(\TypeError::class);
        \DoEveryApp\Util\View\Boolean::get('asdf');
    }
}