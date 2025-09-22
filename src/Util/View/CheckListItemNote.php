<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class CheckListItemNote
{
    public static function byTaskCheckListItem(\DoEveryApp\Entity\Task\CheckListItem $item): string
    {
        return static::byValue(note: $item->getNote());
    }

    public static function byExecutionCheckListItem(\DoEveryApp\Entity\Execution\CheckListItem $item): string
    {
        return static::byValue(note: $item->getNote());
    }

    public static function byValue(?string $note = null): string
    {
        if (null === $note) {
            return '';
        }

        if (false === \DoEveryApp\Util\Registry::getInstance()->isMarkdownTransformerActive()) {
            $note = nl2br(string: \DoEveryApp\Util\View\Escaper::escape(value: $note));
        }
        if (true === \DoEveryApp\Util\Registry::getInstance()->isMarkdownTransformerActive()) {
            $note = new \FastVolt\Helper\Markdown(sanitize: true)
                ->setContent($note)
                ->toHtml()
            ;
        }

        return '<div class="checkListItemNote">' . $note . '</div>';
    }
}
