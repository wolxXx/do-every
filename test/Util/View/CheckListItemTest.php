<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class CheckListItemTest extends \DoEveryAppTest\TestBase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('byValueTestDataProvider')]
    public function testByValue(string $expected, string $name, bool $checked, string|null $note = null)
    {
        $this->assertSame($expected, \DoEveryApp\Util\View\CheckListItem::byValue($name, $checked, $note));
    }


    public static function byValueTestDataProvider(): array
    {
        return [
            [
                '<span title="bar"><span style="color: #154709;"><i class="fa-solid fa-check"></i></span> bar</span>',
                'bar',
                true,
                'bar',
            ],
            [
                '<span title="foo"><span style="color: #154709;"><i class="fa-solid fa-check"></i></span> bar</span>',
                'bar',
                true,
                'foo',
            ],
            [
                '<span title=""><span style="color: #154709;"><i class="fa-solid fa-check"></i></span> bar</span>',
                'bar',
                true,
                null,
            ],
            [
                '<span title=""><span style="color: #f00;"><i class="fa-solid fa-xmark"></i></span> omg asdf</span>',
                'omg asdf',
                false,
                null,
            ],
        ];
    }


    public function testByExecutionCheckListItemUnchecked()
    {
        $expected = '<span title="omg asdf"><span style="color: #f00;"><i class="fa-solid fa-xmark"></i></span> foobar</span>';
        $item     = (new \DoEveryApp\Entity\Execution\CheckListItem())
            ->setName('foobar')
            ->setNote('omg asdf')
            ->setChecked(false)
        ;
        $this->assertSame($expected, \DoEveryApp\Util\View\CheckListItem::byExecutionCheckListItem($item));
    }


    public function testByExecutionCheckListItemChecked()
    {
        $expected = '<span title="omg asdf aaaaaaaa"><span style="color: #154709;"><i class="fa-solid fa-check"></i></span> foobar asdf</span>';
        $item     = (new \DoEveryApp\Entity\Execution\CheckListItem())
            ->setName('foobar asdf')
            ->setNote('omg asdf aaaaaaaa')
            ->setChecked(true)
        ;
        $this->assertSame($expected, \DoEveryApp\Util\View\CheckListItem::byExecutionCheckListItem($item));
    }
}