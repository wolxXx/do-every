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
        Aufgaben
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
                        <th>
                            Aktionen
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach(\DoEveryApp\Entity\Task::getRepository()->findAll() as $task): ?>
                        <tr>
                            <td>
                                <? if(null === $task->getGroup()): ?>
                                    -
                                <? endif ?>
                                <? if(null !== $task->getGroup()): ?>
                                    <?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>
                                <? endif ?>
                            </td>
                            <td>
                                <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
                                </a>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\Worker::get($task->getAssignee()) ?>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\Worker::get($task->getWorkingOn()) ?>
                            </td>
                            <td>
                                <nobr class="buttonRow">
                                   <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                       anzeigen
                                   </a>
                                   <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute($task->getId()) ?>">
                                       bearbeiten
                                   </a>
                                   <a class="primaryButton confirm" href="<?= \DoEveryApp\Action\Task\ResetAction::getRoute($task->getId()) ?>">
                                       reset
                                   </a>
                                   <a class="primaryButton confirm" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute($task->getId()) ?>">
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
        Gruppen
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
                    <th>
                        Aktionen
                    </th>
                </tr>
                </thead>
                <tbody>
                <? foreach(\DoEveryApp\Entity\Group::getRepository()->findAll() as $group): ?>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?>
                        </td>
                        <td>
                            <div class="buttonRow">
                                <a class="primaryButton" href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($group->getId()) ?>">
                                    anzeigen
                                </a>
                                <a class="primaryButton" href="<?= \DoEveryApp\Action\Group\EditAction::getRoute($group->getId()) ?>">
                                    bearbeiten
                                </a>
                                <a class="primaryButton confirm" href="<?= \DoEveryApp\Action\Group\DeleteAction::getRoute($group->getId()) ?>">
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