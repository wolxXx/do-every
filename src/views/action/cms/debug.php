<?php

declare(strict_types=1);

/**
 * @var \Slim\Views\PhpRenderer        $this
 * @var \DoEveryApp\Util\ErrorStore    $errorStore
 * @var string                         $currentRoute
 * @var string                         $currentRoutePattern
 * @var \DoEveryApp\Entity\Worker|null $currentUser
 * @var \DoEveryApp\Util\Translator    $translator
 */

/**
 * @var array $backupFiles
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
                <th>
                    Key
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
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_ADMIN_USER) ?>
                </td>
            </tr>
            <tr>
                <td>
                    cron läuft:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get(\DoEveryApp\Util\Registry::getInstance()->isCronRunning()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_CRON_LOCK) ?>
                </td>
            </tr>
            <tr>
                <td>
                    cron gestartet:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(\DoEveryApp\Util\Registry::getInstance()->getCronStarted()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_CRON_STARTED) ?>
                </td>
            </tr>
            <tr>
                <td>
                    letzte cron ausführung:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(\DoEveryApp\Util\Registry::getInstance()->getLastCron()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_LAST_CRON) ?>
                </td>
            </tr>
            <tr>
                <td>
                    notifier läuft:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get(\DoEveryApp\Util\Registry::getInstance()->isNotifierRunning()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_NOTIFIER_RUNNING) ?>
                </td>
            </tr>
            <tr>
                <td>
                    letzte notifier ausführung:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(\DoEveryApp\Util\Registry::getInstance()->getNotifierLastRun()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_NOTIFIER_LAST_RUN) ?>
                </td>
            </tr>
            <tr>
                <td>
                    letztes backup:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(\DoEveryApp\Util\Registry::getInstance()->getLastBackup()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_LAST_BACKUP) ?>
                </td>
            </tr>
            <tr>
                <td>
                    backup tage:
                </td>
                <td>
                    <?= \DoEveryApp\Util\Registry::getInstance()->getKeepBackupDays() ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_KEEP_BACKUP_DAYS) ?>
                </td>
            </tr>
            <tr>
                <td>
                    Fälligkeitpräzision:
                </td>
                <td>
                    <?= \DoEveryApp\Util\Registry::getInstance()->getPrecisionDue() ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_PRECISION_DUE) ?>
                </td>
            </tr>
            <tr>
                <td>
                    Zeitlinie auffüllen:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get(\DoEveryApp\Util\Registry::getInstance()->doFillTimeLine()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_FILL_TIME_LINE) ?>
                </td>
            </tr>
            <tr>
                <td>
                    maximale Anzahl Worker:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::getInstance()->getMaxWorkers(), '-') ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_MAX_WORKERS) ?>
                </td>
            </tr>
            <tr>
                <td>
                    maximale Anzahl Aufgaben:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::getInstance()->getMaxTasks(), '-') ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_MAX_TASKS) ?>
                </td>
            </tr>
            <tr>
                <td>
                    maximale Anzahl Gruppen:
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::getInstance()->getMaxGroups(), '-') ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(\DoEveryApp\Util\Registry::KEY_MAX_GROUPS) ?>
                </td>
            </tr>
            <tr>
                <td>
                    PHP-Version:
                </td>
                <td>
                    <?= phpversion() ?>
                </td>
                <td>
                    -
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>


<? if (0 !== count($backupFiles)): ?>

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
                <? foreach((array) $entry as $value): ?>
                    <td>
                        <?= \DoEveryApp\Util\View\DisplayValue::do($value) ?>
                    </td>
                <? endforeach ?>
            </tr>
        <? endforeach ?>
        </tbody>
    </table>
</fieldset>

