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
    <?= $translator->workers() ?>
</h1>

<div class="pageButtons">
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\AddAction::getRoute() ?>">
        <?= \DoEveryApp\Util\View\Icon::add() ?>
    </a>
</div>

<table>
    <thead>
        <tr>
            <th>
                <?= $translator->name() ?>
            </th>
            <th>
                <?= $translator->currentlyWorkingOn() ?>
            </th>
            <th>
                <?= $translator->eMail() ?>
            </th>
            <th>
                <?= $translator->hasPasswordQuestion() ?>
            </th>
            <th>
                <?= $translator->isAdminQuestion() ?>
            </th>
            <th>
                <?= $translator->doNotifyLoginsQuestion() ?>
            </th>
            <th>
                <?= $translator->doNotifyDueTasksQuestion() ?>
            </th>
            <th>
                <?= $translator->lastLogin() ?>
            </th>
            <th>
                <?= $translator->lastPasswordChange() ?>
            </th>
            <th class="pullRight">
                <?= $translator->actions() ?>
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
                    <ul>
                    <? foreach($worker->getTasksWorkingOn() as $task): ?>
                        <li>
                            <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
                                <? if(null !== $task->getGroup()): ?>
                                    (<?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>)
                                <? endif ?>
                            </a>
                        </li>

                    <? endforeach ?>
                    </ul>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape($worker->getEmail()) ?>
                </td>
                <td>
                    <? if(null !== $worker->getPassword()): ?>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\UnsetPasswordAction::getRoute($worker->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Icon::trash() ?>
                        </a>
                    <? endif ?>
                    <?= \DoEveryApp\Util\View\Boolean::get(null !== $worker->getPassword()) ?>
                </td>
                <td>
                    <? if(true === $worker->isAdmin()): ?>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\MarkAdminAction::getRoute($worker->getId(), false  ) ?>">
                            <?= \DoEveryApp\Util\View\Icon::refresh() ?>
                        </a>
                    <? endif ?>
                    <? if(false === $worker->isAdmin()): ?>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\MarkAdminAction::getRoute($worker->getId(), true) ?>">
                            <?= \DoEveryApp\Util\View\Icon::refresh() ?>
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
                            <?= \DoEveryApp\Util\View\Icon::list() ?>
                            <?= $translator->log() ?>
                        </a>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\EditAction::getRoute($worker->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Icon::edit() ?>
                        </a>
                        <? if(null === $worker->getTwoFactorSecret()): ?>
                            <a class="warningButton" href="<?= \DoEveryApp\Action\Worker\EnableTwoFactorAction::getRoute($worker->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Icon::on() ?>
                                <?= $translator->addTwoFactor() ?>
                            </a>
                        <? endif ?>
                        <? if(null !== $worker->getTwoFactorSecret()): ?>
                            <a class="warningButton confirm" href="<?= \DoEveryApp\Action\Worker\DisableTwoFactorAction::getRoute($worker->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Icon::off() ?>
                                <?= $translator->removeTwoFactor() ?>
                            </a>
                        <? endif ?>
                        <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Worker\DeleteAction::getRoute($worker->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Icon::trash() ?>
                        </a>
                    </nobr>
                </td>
            </tr>
        <? endforeach ?>
    </tbody>
</table>
