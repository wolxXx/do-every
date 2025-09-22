<?php

declare(strict_types=1);

namespace DoEveryApp\Util\View;

class TaskNote
{
    public static function byTask(\DoEveryApp\Entity\Task $task): string
    {
        return static::byValue($task->getNote());
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
        $noteLegend = \DoEveryApp\Util\DependencyContainer::getInstance()
                                                          ->getTranslator()
                                                          ->notice()
        ;

        return '<fieldset class="taskNote"><legend>' . $noteLegend . '</legend>' . $note . '</fieldset>';
    }
}
