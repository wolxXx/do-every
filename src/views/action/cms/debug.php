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

        <tr>
            <td>
                super admin admin :<br />
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Worker::get(\DoEveryApp\Util\Registry::getInstance()->getAdminUser()) ?>
            </td>
        </tr>

        <tr>
            <td>
                cron läuft:
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Boolean::get(\DoEveryApp\Util\Registry::getInstance()->isCronRunning()) ?>
            </td>
        </tr>
        <tr>
            <td>
                cron gestartet:
            </td>
            <td>
                <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(\DoEveryApp\Util\Registry::getInstance()->getCronStarted()) ?>
            </td>
        </tr>
        <tr>
            <td>
                letzte cron ausführung:
            </td>
            <td>
                <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(\DoEveryApp\Util\Registry::getInstance()->getLastCron()) ?>
            </td>
        </tr>
        <tr>
            <td>
                letztes backup:
            </td>
            <td>
                <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(\DoEveryApp\Util\Registry::getInstance()->getLastBackup()) ?>
            </td>
        </tr>
        <tr>
            <td>
                Fälligkeitpräzision:
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->getPrecisionDue() ?>
            </td>
        </tr>
        <tr>
            <td>
                Zeitlinie auffüllen:
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Boolean::get(\DoEveryApp\Util\Registry::getInstance()->doFillTimeLine()) ?>
            </td>
        </tr>
        <tr>
            <td>
                maximale Anzahl Worker:
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::getInstance()->getMaxWorkers(), '-') ?>
            </td>
        </tr>
        <tr>
            <td>
                maximale Anzahl Aufgaben:
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::getInstance()->getMaxTasks(), '-') ?>
            </td>
        </tr>
        <tr>
            <td>
                maximale Anzahl Gruppen:
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::getInstance()->getMaxGroups(), '-') ?>
            </td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <? foreach(\DoEveryApp\Entity\Registry::getRepository()->findAll() as $entry): ?>
            <tr>
                <? foreach((array) $entry as $key => $value): ?>
                    <th>
                        <?= \DoEveryApp\Util\View\Escaper::escape($key) ?>
                    </th>
                <? endforeach ?>
            </tr>
            <? break ?>
        <? endforeach ?>
    </thead>
    <tbody>
        <? foreach(\DoEveryApp\Entity\Registry::getRepository()->findAll() as $entry): ?>
            <tr>
                <? foreach((array) $entry as $key => $value): ?>
                    <td>
                        <?= \DoEveryApp\Util\View\DisplayValue::do($value) ?>
                    </td>
                <? endforeach ?>
            </tr>
        <? endforeach ?>
    </tbody>
</table>