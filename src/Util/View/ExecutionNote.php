<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class ExecutionNote
{
    public static function byExecution(\DoEveryApp\Entity\Execution $execution): string
    {
        return static::byValue($execution->getNote());
    }

    public static function byValue(?string $note = null): string
    {
        if (null === $note) {
            return '';
        }

        $note = nl2br(string: \DoEveryApp\Util\View\Escaper::escape(value: $note));

        return '<div class="executionNote">' . $note . '</div>';
    }
}
