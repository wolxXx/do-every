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
        \ob_start();
        if (true === $checked) {
            require ROOT_DIR . DIRECTORY_SEPARATOR . 'src/views/icon/check.php';
            $color = '#154709';
        }
        if (false === $checked) {
            require ROOT_DIR . DIRECTORY_SEPARATOR . 'src/views/icon/cross.php';
            $color = '#f00';
        }
        $icon   = \ob_get_clean();
        $icon   = '<span style="color: ' . $color . ';">' . $icon . '</span>';
        $result = '<span title="' . $note . '">' . $icon . ' ' . Escaper::escape($name) . '</span>';
        $result = \str_replace(\PHP_EOL, '', $result);

        return $result;
    }
}
