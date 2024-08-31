<?php

declare(strict_types=1);
/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 * @var $currentUser  \DoEveryApp\Entity\Worker|null
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
                letzter Login
            </th>
            <th>
                Aktionen
            </th>
        </tr>
    </thead>
    <tbody>
        <? foreach(\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
            <tr>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape($worker->getName()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape($worker->getEmail()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get(null !== $worker->getPassword()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get($worker->isAdmin()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTime($worker->getLastLogin()) ?>
                </td>
                <td>
                    <nobr class="buttonRow">
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute($worker->getId()) ?>">
                            Log
                        </a>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\EditAction::getRoute($worker->getId()) ?>">
                            bearbeiten

                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\UnsetPasswordAction::getRoute($worker->getId()) ?>">
                            Passwort löschen
                        </a>
                        <? if(true === $worker->isAdmin()): ?>
                            <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\MarkAdminAction::getRoute($worker->getId(), false  ) ?>">
                                kein admin mehr
                            </a>
                        <? endif ?>
                        <? if(false === $worker->isAdmin()): ?>
                            <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\MarkAdminAction::getRoute($worker->getId(), true) ?>">
                                ist admin
                            </a>
                        <? endif ?>
                        <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Worker\DeleteAction::getRoute($worker->getId()) ?>">
                            löschen
                        </a>
                    </nobr>
                </td>
            </tr>
        <? endforeach ?>
    </tbody>
</table>
