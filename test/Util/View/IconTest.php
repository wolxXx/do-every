<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class IconTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('getTestDataProvider')]
    public function testIcon(string $expected, string $actual): void
    {
        $this->assertSame(expected: $expected, actual: $actual);
    }


    public static function getTestDataProvider(): array
    {
        return [
            ['<i class="fa fa-plus"></i>', \DoEveryApp\Util\View\Icon::add()],
            ['<i class="fa-solid fa-check"></i>', \DoEveryApp\Util\View\Icon::check()],
            ['<i class="fa-solid fa-clone"></i>', \DoEveryApp\Util\View\Icon::clone()],
            ['<i class="fa-regular fa-clipboard"></i>', \DoEveryApp\Util\View\Icon::copy()],
            ['<i class="fa-solid fa-xmark"></i>', \DoEveryApp\Util\View\Icon::cross()],
            ['<i class="fa-solid fa-pencil"></i>', \DoEveryApp\Util\View\Icon::edit()],
            ['<i class="fa-solid fa-hand"></i>', \DoEveryApp\Util\View\Icon::hand()],
            ['<i class="fa-solid fa-list"></i>', \DoEveryApp\Util\View\Icon::list()],
            ['<i class="fa-solid fa-moon"></i>', \DoEveryApp\Util\View\Icon::off()],
            ['<i class="fa-solid fa-power-off"></i>', \DoEveryApp\Util\View\Icon::on()],
            ['<i class="fa-solid fa-arrows-rotate"></i>', \DoEveryApp\Util\View\Icon::refresh()],
            ['<i class="fa-solid fa-floppy-disk"></i>', \DoEveryApp\Util\View\Icon::save()],
            ['<i class="fa-solid fa-eye"></i>', \DoEveryApp\Util\View\Icon::show()],
            ['<i class="fa-solid fa-trash"></i>', \DoEveryApp\Util\View\Icon::trash()],
            ['<i class="fa-solid fa-wrench"></i>', \DoEveryApp\Util\View\Icon::wrench()],
        ];
    }
}