<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class DurationTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('getTestDataProvider')]
    public function testGetByValue($expected, int|null $duration)
    {
        $this->assertSame(expected: $expected, actual: \DoEveryApp\Util\View\Duration::byValue(duration: $duration));
    }
    #[\PHPUnit\Framework\Attributes\DataProvider('getTestDataProvider')]
    public function testGet($expected, int|null $duration)
    {
        $this->assertSame(expected: $expected, actual: \DoEveryApp\Util\View\Duration::byExecution(new \DoEveryApp\Entity\Execution()->setDuration(duration: $duration)));
    }


    public static function getTestDataProvider(): array
    {
        return [
            ['-', null],
            ['-', 0],
            ['eine Minute', 1],
            ['zwei Minuten', 2],
            ['drei Minuten', 3],
            ['vier Minuten', 4],
            ['fünf Minuten', 5],
            ['6 Minuten', 6],
            ['7 Minuten', 7],
            ['8 Minuten', 8],
            ['9 Minuten', 9],
            ['10 Minuten', 10],
            ['100 Minuten', 100],
            ['3 Stunden', 200],
            ['8 Stunden', 500],
            ['17 Stunden', 1000],
            ['7 Tage', 10000],
            ['21 Tage', 30000],
            ['35 Tage', 50000],
            ['69 Tage', 100000],
            ['694 Tage', 1000000],
        ];
    }
}