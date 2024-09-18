<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class DateTimeTest extends \DoEveryAppTest\TestBase
{
    public function testGetForNull()
    {
        $this->assertSame('-', \DoEveryApp\Util\View\DateTime::getDate(null));
    }
    public function testGetForDate()
    {
        $this->assertSame('<nobr>01.01.2024</nobr>', \DoEveryApp\Util\View\DateTime::getDate(new \DateTime('2024-01-01 12:34:56')));
    }
    public function testGetMediumDateMediumTimeForNull()
    {
        $this->assertSame('-', \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(null));
    }
    public function testGetMediumDateMediumTimeForDate()
    {
        $this->assertSame('<nobr>01.01.2024, 12:34:56</nobr>', \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(new \DateTime('2024-01-01 12:34:56')));
    }
    public function testGetMediumDateShorTimeForNull()
    {
        $this->assertSame('-', \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateShortTime(null));
    }
    public function testGetMediumDateShortTimeForDate()
    {
        $this->assertSame('<nobr>01.01.2024, 12:34</nobr>', \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateShortTime(new \DateTime('2024-01-01 12:34:56')));
    }
}