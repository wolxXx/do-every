<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 * @var $translator          \DoEveryApp\Util\Translator
 */

/**
 * @var $backupFiles array
 */
?>

<h1>
    Debug
</h1>
<fieldset>
    <legend>
        <?= $translator->settings() ?>
    </legend>
    <table class="keyValue">
        <thead>
        <tr>
            <th>
                <?= $translator->what() ?>
            </th>
            <th>
                <?= $translator->value() ?>
            </th>
        </tr>
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
                backup tage:
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->getKeepBackupDays() ?>
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
</fieldset>


<? if(0 !== sizeof($backupFiles)): ?>

    <fieldset>
        <legend>
            Backup-Dateien
        </legend>
        <div class="pageButtons">
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Cms\DownloadBackupAction::getRoute(base64_encode('all')) ?>">
                alle herunterladen
            </a>
        </div>
        <table class="withActions">
            <thead>
                <tr>
                    <th>
                        Datum
                    </th>
                    <th>
                        Größe
                    </th>
                    <th class="pullRight">
                        Aktion
                    </th>
                </tr>
            </thead>
            <tbody>
                <? foreach($backupFiles as $debugFile => $fileSize): ?>
                    <tr>
                        <td>

                            <?
                            $date = str_replace(['backup_', '.sql', '_'], ['','', ' '], basename($debugFile));
                            $dateSplit = explode(' ', $date);
                            $date = $dateSplit[0] . ' '. str_replace('-', ':', $dateSplit[1]);
                            ?>
                            <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateShortTime(new \DateTime($date)) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\FileSize::humanReadable($fileSize) ?>
                        </td>
                        <td class="pullRight">
                            <a class="primaryButton" href="<?= \DoEveryApp\Action\Cms\DownloadBackupAction::getRoute(base64_encode($debugFile)) ?>">
                                herunterladen
                            </a>
                        </td>
                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    </fieldset>
<? endif ?>

<fieldset>
    <legend>
        Datenbank-Registry
    </legend>
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
</fieldset>

