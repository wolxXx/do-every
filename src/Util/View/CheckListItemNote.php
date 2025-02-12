<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class CheckListItemNote
{
    public static function byTaskCheckListItem(\DoEveryApp\Entity\Task\CheckListItem $item): string
    {
        return static::byValue($item->getNote());
    }

    public static function byExecutionCheckListItem(\DoEveryApp\Entity\Execution\CheckListItem $item): string
    {
        return static::byValue($item->getNote());
    }

    public static function byValue(?string $note = null): string
    {
        if (null === $note) {
            return '';
        }

        $note = nl2br(\DoEveryApp\Util\View\Escaper::escape($note));

        return '<div class="checkListItemNote">' . $note . '</div>';
    }
}
