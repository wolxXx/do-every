<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class CheckListItemNoteTest extends \DoEveryAppTest\TestBase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('byValueTestDataProvider')]
    public function testByValue(string $expected, string|null $note = null)
    {
        $this->assertSame($expected, \DoEveryApp\Util\View\CheckListItemNote::byValue($note));
    }


    public static function byValueTestDataProvider(): array
    {
        return [
            [
                '<div class="checkListItemNote"></div>',
                '',
            ],
            [
                '',
                null,
            ],
            [
                '<div class="checkListItemNote">bar</div>',
                'bar',
            ],
            [
                '<div class="checkListItemNote">safasf<br />
asfssa<br />
safsafsaf</div>',
                'safasf
asfssa
safsafsaf',
            ],
        ];
    }


    #[\PHPUnit\Framework\Attributes\DataProvider('byExecutionCheckListItemTestDataProvider')]
    public function testByExecutionCheckListItem(string $expected, \DoEveryApp\Entity\Execution\CheckListItem $note)
    {
        $this->assertSame($expected, \DoEveryApp\Util\View\CheckListItemNote::byExecutionCheckListItem($note));
    }


    public static function byExecutionCheckListItemTestDataProvider(): array
    {
        return [
            [
                '',
                (new \DoEveryApp\Entity\Execution\CheckListItem())
                    ->setNote(null),
            ],
            [
                '<div class="checkListItemNote"></div>',
                (new \DoEveryApp\Entity\Execution\CheckListItem())
                    ->setNote(''),
            ],
            [
                '<div class="checkListItemNote">omg 1234</div>',
                (new \DoEveryApp\Entity\Execution\CheckListItem())
                    ->setNote('omg 1234'),
            ],
            [
                '<div class="checkListItemNote">omg 1234<br />
safsfafaf<br />
asfsafsaf</div>',
                (new \DoEveryApp\Entity\Execution\CheckListItem())
                    ->setNote('omg 1234
safsfafaf
asfsafsaf'),

            ],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('byTaskCheckListItemTestDataProvider')]
    public function testByTaskCheckListItem(string $expected, \DoEveryApp\Entity\Task\CheckListItem $note)
    {
        $this->assertSame($expected, \DoEveryApp\Util\View\CheckListItemNote::byTaskCheckListItem($note));
    }


    public static function byTaskCheckListItemTestDataProvider(): array
    {
        return [
            [
                '',
                (new \DoEveryApp\Entity\Task\CheckListItem())
                    ->setNote(null),
            ],
            [
                '<div class="checkListItemNote"></div>',
                (new \DoEveryApp\Entity\Task\CheckListItem())
                    ->setNote(''),
            ],
            [
                '<div class="checkListItemNote">omg 1234</div>',
                (new \DoEveryApp\Entity\Task\CheckListItem())
                    ->setNote('omg 1234'),
            ],
            [
                '<div class="checkListItemNote">omg 1234<br />
safsfafaf<br />
asfsafsaf</div>',
                (new \DoEveryApp\Entity\Task\CheckListItem())
                    ->setNote('omg 1234
safsfafaf
asfsafsaf'),

            ],
        ];
    }
}