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
    Einstellungen
</h1>

<div class="pageButtons">
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Cms\EditSettingsAction::getRoute() ?>">
        <?= $this->fetchTemplate('icon/wrench.php') ?>
        Einstellungen bearbeiten
    </a>
</div>


<table class="keyValue">
    <thead>
        <tr>
            <th>
                Schlüssel
            </th>
            <th>
                Wert
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                Zeitlinie auffüllen?
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Boolean::get(\DoEveryApp\Util\Registry::getInstance()->doFillTimeLine()) ?>
            </td>
        </tr>
        <tr>
            <td>
                Fälligkeitpräzision
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->getPrecisionDue() ?>
            </td>
        </tr>
        <tr>
            <td>
                Backups aufheben (Tage)
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->getKeepBackupDays() ?>
            </td>
        </tr>
    </tbody>
</table>