<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class CheckListItem
{
    public static function byExecutionCheckListItem(\DoEveryApp\Entity\Execution\CheckListItem $item): string
    {
        return static::byValue($item->getName(), $item->isChecked(), $item->getNote());
    }


    public static function byValue(string $name, bool $checked, string|null $note = null): string
    {
        $color = '#ff00a0';
        if (true === $checked) {
            $icon = Icon::check();
            $color = '#154709';
        }
        if (false === $checked) {
            $icon = Icon::cross();
            $color = '#f00';
        }
        $icon   = '<span style="color: ' . $color . ';">' . $icon . '</span>';
        $result = '<span title="' . $note . '">' . $icon . ' ' . Escaper::escape($name) . '</span>';
        $result = \str_replace(\PHP_EOL, '', $result);

        return $result;
    }
}
