<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class FileSizeTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('getTestDataProvider')]
    public function testGet($expected, int $size)
    {
        $this->assertSame(expected: $expected, actual: \DoEveryApp\Util\View\FileSize::humanReadable(size: $size));
    }


    public static function getTestDataProvider(): array
    {
        return [
            ['0 B', 0],
            ['0 B', 0],
            ['0 B', 0],
            ['0 B', 0],
            ['1 B', 1],
            ['1 B', 1],
            ['1 B', 1],
            ['1 B', 1],
            ['5 B', 5],
            ['5 B', 5],
            ['5 B', 5],
            ['5 B', 5],
            ['10 B', 10],
            ['10 B', 10],
            ['10 B', 10],
            ['10 B', 10],
            ['100 B', 100],
            ['100 B', 100],
            ['100 B', 100],
            ['100 B', 100],
            ['1000 B', 1000],
            ['1000 B', 1000],
            ['1000 B', 1000],
            ['1000 B', 1000],
            ['10 kB', 10000],
            ['10 kB', 10000],
            ['10 kB', 10000],
            ['10 kB', 10000],
            ['98 kB', 100000],
            ['98 kB', 100000],
            ['98 kB', 100000],
            ['98 kB', 100000],
            ['977 kB', 1000000],
            ['977 kB', 1000000],
            ['977 kB', 1000000],
            ['977 kB', 1000000],
            ['9,54 MB', 10000000],
            ['9,54 MB', 10000000],
            ['9,54 MB', 10000000],
            ['9,54 MB', 10000000],
            ['95,37 MB', 100000000],
            ['95,37 MB', 100000000],
            ['95,37 MB', 100000000],
            ['95,37 MB', 100000000],
            ['953,67 MB', 1000000000],
            ['953,67 MB', 1000000000],
            ['953,67 MB', 1000000000],
            ['953,67 MB', 1000000000],
        ];
    }
}