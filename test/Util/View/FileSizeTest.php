<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class FileSizeTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('getTestDataProvider')]
    public function testGet($expected, int $size, ?int $decimals)
    {
        $this->assertSame($expected, \DoEveryApp\Util\View\FileSize::humanReadable($size));
    }


    public static function getTestDataProvider(): array
    {
        return [
            ['0 B', 0, null],
            ['0 B', 0, 1],
            ['0 B', 0, 2],
            ['0 B', 0, 3],
            ['1 B', 1, null],
            ['1 B', 1, 1],
            ['1 B', 1, 2],
            ['1 B', 1, 3],
            ['5 B', 5, null],
            ['5 B', 5, 1],
            ['5 B', 5, 2],
            ['5 B', 5, 3],
            ['10 B', 10, null],
            ['10 B', 10, 1],
            ['10 B', 10, 2],
            ['10 B', 10, 3],
            ['100 B', 100, null],
            ['100 B', 100, 1],
            ['100 B', 100, 2],
            ['100 B', 100, 3],
            ['1000 B', 1000, null],
            ['1000 B', 1000, 1],
            ['1000 B', 1000, 2],
            ['1000 B', 1000, 3],
            ['10 kB', 10000, null],
            ['10 kB', 10000, 1],
            ['10 kB', 10000, 2],
            ['10 kB', 10000, 3],
            ['98 kB', 100000, null],
            ['98 kB', 100000, 1],
            ['98 kB', 100000, 2],
            ['98 kB', 100000, 3],
            ['977 kB', 1000000, null],
            ['977 kB', 1000000, 1],
            ['977 kB', 1000000, 2],
            ['977 kB', 1000000, 3],
            ['9,54 MB', 10000000, null],
            ['9,54 MB', 10000000, 1],
            ['9,54 MB', 10000000, 2],
            ['9,54 MB', 10000000, 3],
            ['95,37 MB', 100000000, null],
            ['95,37 MB', 100000000, 1],
            ['95,37 MB', 100000000, 2],
            ['95,37 MB', 100000000, 3],
            ['953,67 MB', 1000000000, null],
            ['953,67 MB', 1000000000, 1],
            ['953,67 MB', 1000000000, 2],
            ['953,67 MB', 1000000000, 3],
        ];
    }
}