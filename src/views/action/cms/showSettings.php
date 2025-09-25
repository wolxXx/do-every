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
?>

<h1>
    <?= $translator->settings() ?>
</h1>

<div class="pageButtons">
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Cms\EditSettingsAction::getRoute() ?>">
        <?= \DoEveryApp\Util\View\Icon::wrench() ?>
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
            <th>
                <?= $translator->actions() ?> / <?= $translator->note() ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?= $translator->fillTimeLineQuestion() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Boolean::get(value: \DoEveryApp\Util\Registry::getInstance()->doFillTimeLine()) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $translator->duePrecision() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->getPrecisionDue() ?>
            </td>
            <td>
                Nachkommastellen
            </td>
        </tr>
        <tr>
            <td>
                <?= $translator->backupDelay() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->backupDelay() ?>
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
        <tr>
            <td>
                <?= $translator->passwordChangeInterval() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\Registry::getInstance()->passwordChangeInterval() ?>
            </td>
            <td>
                0 bedeutet keine
            </td>
        </tr>
        <tr>
            <td>
                <?= $translator->useTimer() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Boolean::get(value: \DoEveryApp\Util\Registry::getInstance()->doUseTimer()) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $translator->markdownTransformationEnabled() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Boolean::get(value: \DoEveryApp\Util\Registry::getInstance()->isMarkdownTransformerActive()) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $translator->davEnabled() ?>
            </td>
            <td>
                <?= \DoEveryApp\Util\View\Boolean::get(value: null !== \DoEveryApp\Util\Registry::getInstance()->getDavUser()) ?>
            </td>
            <td>
                <a href="<?= \DoEveryApp\Action\Cms\DisableDavAction::getRoute() ?>">
                    <?= $translator->delete() ?>
                </a>
                <a href="<?= \DoEveryApp\Action\Cms\ResetDavAction::getRoute() ?>">
                    <?= $translator->reset() ?>
                </a>
                <br />
                <?= $translator->davUser() ?>: <?= \DoEveryApp\Util\Registry::getInstance()->getDavUser() ?><br />
                <?= $translator->davPassword() ?>: <?= \DoEveryApp\Util\Registry::getInstance()->getDavPassword() ?><br />
                <?= $translator->davUrl() ?>: <?= $_SERVER['REQUEST_SCHEME'] ?>://<?= $_SERVER['HTTP_HOST'] ?><?= \DoEveryApp\Action\Task\CalendarAction::getRoute() ?><br />
            </td>
        </tr>
    </tbody>
</table>