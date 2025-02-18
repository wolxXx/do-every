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
        <?php foreach(\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
            <tr>
                <td>
                    <?= \DoEveryApp\Util\View\Worker::get(worker: $worker) ?>
                </td>
                <td>
                    <ul>
                    <?php foreach($worker->getTasksWorkingOn() as $task): ?>
                        <li>
                            <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) ?>
                                <?php if(null !== $task->getGroup()): ?>
                                    (<?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) ?>)
                                <?php endif ?>
                            </a>
                        </li>

                    <?php endforeach ?>
                    </ul>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Escaper::escape(value: $worker->getEmail()) ?>
                </td>
                <td>
                    <?php if(null !== $worker->getPassword()): ?>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\UnsetPasswordAction::getRoute(id: $worker->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Icon::trash() ?>
                        </a>
                    <?php endif ?>
                    <?= \DoEveryApp\Util\View\Boolean::get(value: null !== $worker->getPassword()) ?>
                </td>
                <td>
                    <?php if(true === $worker->isAdmin()): ?>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\MarkAdminAction::getRoute(id: $worker->getId(), admin: false) ?>">
                            <?= \DoEveryApp\Util\View\Icon::refresh() ?>
                        </a>
                    <?php endif ?>
                    <?php if(false === $worker->isAdmin()): ?>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\MarkAdminAction::getRoute(id: $worker->getId(), admin: true) ?>">
                            <?= \DoEveryApp\Util\View\Icon::refresh() ?>
                        </a>
                    <?php endif ?>
                    <?= \DoEveryApp\Util\View\Boolean::get(value: $worker->isAdmin()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get(value: $worker->doNotifyLogin()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get(value: $worker->doNotify()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(dateTime: $worker->getLastLogin()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(dateTime: $worker->getLastPasswordChange()) ?>
                </td>
                <td class="pullRight">
                    <nobr class="buttonRow">
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute(id: $worker->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Icon::list() ?>
                            <?= $translator->log() ?>
                        </a>
                        <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\EditAction::getRoute(id: $worker->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Icon::edit() ?>
                        </a>
                        <?php if(null === $worker->getTwoFactorSecret()): ?>
                            <a class="warningButton" href="<?= \DoEveryApp\Action\Worker\EnableTwoFactorAction::getRoute(id: $worker->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Icon::on() ?>
                                <?= $translator->addTwoFactor() ?>
                            </a>
                        <?php endif ?>
                        <?php if(null !== $worker->getTwoFactorSecret()): ?>
                            <a class="warningButton confirm" href="<?= \DoEveryApp\Action\Worker\DisableTwoFactorAction::getRoute(id: $worker->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Icon::off() ?>
                                <?= $translator->removeTwoFactor() ?>
                            </a>
                        <?php endif ?>
                        <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Worker\DeleteAction::getRoute(id: $worker->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Icon::trash() ?>
                        </a>
                    </nobr>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
