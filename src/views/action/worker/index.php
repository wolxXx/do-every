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

<h1>Workers</h1>

<div>
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\AddAction::getRoute() ?>">
        <?= $this->fetchTemplate('icon/add.php') ?>
        neu
    </a>
</div>

<table>
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                Email
            </th>
            <th>
                hat Passwort?
            </th>
            <th>
                ist Admin?
            </th>
            <th>
                Logins benachrichtigen?
            </th>
            <th>
                Fälligkeiten benachrichtigen?
            </th>
            <th>
                letzter Login
            </th>
            <th>
                letzte Passwortänderung
            </th>
            <th class="pullRight">
                Aktionen
            </th>
        </tr>
    </thead>
    <tbody>
        <? foreach(\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
            <tr>
                <td>
                    <?= \DoEveryApp\Util\View\Worker::get($worker) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape($worker->getEmail()) ?>
                </td>
                <td>
                    <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\UnsetPasswordAction::getRoute($worker->getId()) ?>">
                        <?= $this->fetchTemplate('icon/trash.php') ?>
                    </a>
                    <?= \DoEveryApp\Util\View\Boolean::get(null !== $worker->getPassword()) ?>
                </td>
                <td>
                    <? if(true === $worker->isAdmin()): ?>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\MarkAdminAction::getRoute($worker->getId(), false  ) ?>">
                            <?= $this->fetchTemplate('icon/refresh.php') ?>
                        </a>
                    <? endif ?>
                    <? if(false === $worker->isAdmin()): ?>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\MarkAdminAction::getRoute($worker->getId(), true) ?>">
                            <?= $this->fetchTemplate('icon/refresh.php') ?>
                        </a>
                    <? endif ?>
                    <?= \DoEveryApp\Util\View\Boolean::get($worker->isAdmin()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get($worker->doNotifyLogin()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get($worker->doNotify()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime($worker->getLastLogin()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime($worker->getLastPasswordChange()) ?>
                </td>
                <td class="pullRight">
                    <nobr class="buttonRow">
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute($worker->getId()) ?>">
                            Log
                        </a>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\EditAction::getRoute($worker->getId()) ?>">
                            bearbeiten
                        <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Worker\DeleteAction::getRoute($worker->getId()) ?>">
                            löschen
                        </a>
                    </nobr>
                </td>
            </tr>
        <? endforeach ?>
    </tbody>
</table>
