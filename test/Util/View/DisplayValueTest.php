<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class DisplayValueTest extends \DoEveryAppTest\TestBase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('getTestDataProvider')]
    public function testGet(string $expected, mixed $value): void
    {
        $this->assertSame(expected: $expected, actual: \DoEveryApp\Util\View\DisplayValue::do(value: $value));
    }


    public static function getTestDataProvider(): array
    {
        return [
            ['-null-', null],
            ['', ''],
            ['&lt;a href=&quot;#&quot;&gt;mazel tov!!&lt;/a&gt;', '<a href="#">mazel tov!!</a>'],
            ['foo', 'foo'],
            ['ja', true],
            ['nein', false],
            ['<nobr>01.01.2024, 12:34:56</nobr>', new \DateTime(datetime: '2024-01-01 12:34:56')],
            ['1', 1],
            ['1,3', 1.3],
            ['1,312', 1.312],

        ];

    }

}