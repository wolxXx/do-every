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
?>

<h1>
    <?= $translator->settings() ?>
</h1>

<div class="pageButtons">
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Cms\EditSettingsAction::getRoute() ?>">
        <?= $this->fetchTemplate('icon/wrench.php') ?>
        <?= $translator->editSettings() ?>
    </a>
</div>


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
                <?= $translator->fillTimeLineQuestion() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Boolean::get(\DoEveryApp\Util\Registry::getInstance()->doFillTimeLine()) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $translator->duePrecision() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->getPrecisionDue() ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $translator->keepBackupDays() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->getKeepBackupDays() ?>
            </td>
        </tr>
    </tbody>
</table>