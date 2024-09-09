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

<div class="row">
    <div class="column">
        <h1>
            Aufgaben
        </h1>
        <br/>
        <a href="<?= \DoEveryApp\Action\Task\AddAction::getRoute() ?>" class="primaryButton">
            <?= $this->fetchTemplate('icon/add.php') ?>
            neue Aufgabe
        </a>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>
                            Gruppe
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            zugewiesen
                        </th>
                        <th>
                            arbeitet daran
                        </th>
                        <th class="pullRight">
                            Aktionen
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach(\DoEveryApp\Entity\Task::getRepository()->findForIndex() as $task): ?>
                        <tr>
                            <td>
                                <? if(null === $task->getGroup()): ?>
                                    -
                                <? endif ?>
                                <? if(null !== $task->getGroup()): ?>
                                    <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($task->getGroup()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>
                                    </a>
                                <? endif ?>
                            </td>
                            <td>
                                <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
                                </a>
                            </td>
                            <td>
                                <? if(null !== $task->getAssignee()): ?>
                                    <a href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute($task->getAssignee()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Worker::get($task->getAssignee()) ?>
                                    </a>
                                <? endif ?>
                                <? if(null === $task->getAssignee()): ?>
                                    <?= \DoEveryApp\Util\View\Worker::get($task->getAssignee()) ?>
                                <? endif ?>
                            </td>
                            <td>
                                <? if(null !== $task->getWorkingOn()): ?>
                                    <a href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute($task->getWorkingOn()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Worker::get($task->getWorkingOn()) ?>
                                    </a>
                                <? endif ?>
                                <? if(null === $task->getWorkingOn()): ?>
                                    <?= \DoEveryApp\Util\View\Worker::get($task->getWorkingOn()) ?>
                                <? endif ?>
                            </td>
                            <td class="pullRight">
                                <nobr class="buttonRow">
                                   <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                       <?= $this->fetchTemplate('icon/show.php') ?>
                                       anzeigen
                                   </a>
                                   <a class="warningButton" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute($task->getId()) ?>">
                                       <?= $this->fetchTemplate('icon/edit.php') ?>
                                       bearbeiten
                                   </a>
                                   <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\ResetAction::getRoute($task->getId()) ?>">
                                       <?= $this->fetchTemplate('icon/refresh.php') ?>
                                       reset
                                   </a>
                                   <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute($task->getId()) ?>">
                                       <?= $this->fetchTemplate('icon/trash.php') ?>
                                       löschen
                                   </a>
                                </nobr>
                            </td>
                        </tr>
                    <? endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="column">
        <h1>
            Gruppen
        </h1>
        <br />
        <a href="<?= \DoEveryApp\Action\Group\AddAction::getRoute() ?>" class="primaryButton">
            <?= $this->fetchTemplate('icon/add.php') ?>
            neue Gruppe
        </a>
        <div>
            <table>
                <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th class="pullRight">
                        Aktionen
                    </th>
                </tr>
                </thead>
                <tbody>
                <? foreach(\DoEveryApp\Entity\Group::getRepository()->findIndexed() as $group): ?>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?>
                        </td>
                        <td class="pullRight">
                            <div class="buttonRow">
                                <a class="primaryButton" href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($group->getId()) ?>">
                                    <?= $this->fetchTemplate('icon/show.php') ?>
                                    anzeigen
                                </a>
                                <a class="warningButton" href="<?= \DoEveryApp\Action\Group\EditAction::getRoute($group->getId()) ?>">
                                    <?= $this->fetchTemplate('icon/edit.php') ?>
                                    bearbeiten
                                </a>
                                <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Group\DeleteAction::getRoute($group->getId()) ?>">
                                    <?= $this->fetchTemplate('icon/trash.php') ?>
                                    löschen
                                </a>
                            </div>
                        </td>
                    </tr>
                <? endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>