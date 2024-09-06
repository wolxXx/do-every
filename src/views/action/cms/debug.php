<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 */

?>

<h1>
    Debug
</h1>

<table>
    <thead>

    </thead>
    <tbody>
        <? foreach(\DoEveryApp\Entity\Registry::getRepository()->findAll() as $entry): ?>
            <tr>
                <? foreach((array) $entry as $key => $value): ?>
                    <td>
                        <?= \DoEveryApp\Util\View\Escaper::escape($key) ?>:
                        <?= \DoEveryApp\Util\View\DisplayValue::do($value) ?>
                        <? #\DoEveryApp\Util\Debugger::debug($value); ?>
                    </td>
                <? endforeach ?>
            </tr>
        <? endforeach ?>
        <tr>
            <td>

            </td>
        </tr>
    </tbody>
</table>