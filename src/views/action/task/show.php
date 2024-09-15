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

/**
 * @var $task            \DoEveryApp\Entity\Task
 */
$lastExecution = $task::getRepository()->getLastExecution($task);
$executions    = $task->getExecutions();
$durations    = \DoEveryApp\Definition\Durations::FactoryByTask($task);
?>

<h1>
    Aufgabe: <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
    <? if (null !== $task->getGroup()): ?>
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($task->getGroup()->getId()) ?>">
            (<?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>)
        </a>
    <? endif ?>
</h1>

<h2>
    <?= \DoEveryApp\Util\View\Due::getByTask($task) ?>
</h2>

<div class="pageButtons buttonRow">
    <? if(null === $task->getWorkingOn()): ?>
        <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\MarkWorkingAction::getRoute($task->getId(), $currentUser->getId()) ?>">
            <?= $this->fetchTemplate('icon/hand.php') ?>
            ich arbeite daran
        </a>
    <? endif ?>
    <? if(null !== $task->getWorkingOn()): ?>
        <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\MarkWorkingAction::getRoute($task->getId()) ?>">
            <?= $this->fetchTemplate('icon/cross.php') ?>
            niemand arbeitet daran
        </a>
    <? endif ?>

    <a class="primaryButton" href="<?= \DoEveryApp\Action\Execution\AddAction::getRoute($task->getId()) ?>">
        <?= $this->fetchTemplate('icon/add.php') ?>
        Ausführung eintragen
    </a>
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute($task->getId()) ?>">
        <?= $this->fetchTemplate('icon/edit.php') ?>
        bearbeiten
    </a>
    <a class="warningButton confirm" href="<?= \DoEveryApp\Action\Task\ResetAction::getRoute($task->getId()) ?>">
        <?= $this->fetchTemplate('icon/refresh.php') ?>
        reset
    </a>
    <? if(true === $task->isActive()): ?>
        <a class="warningButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute($task->getId(), false) ?>">
            <?= $this->fetchTemplate('icon/off.php') ?>
            deaktivieren
        </a>
    <? endif ?>
    <? if(false === $task->isActive()): ?>
        <a class="warningButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute($task->getId(), true) ?>">
            <?= $this->fetchTemplate('icon/on.php') ?>
            aktivieren
        </a>
    <? endif ?>

    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute($task->getId()) ?>">
        <?= $this->fetchTemplate('icon/trash.php') ?>
        löschen
    </a>
</div>

<hr />

<div class="row">
    <div class="column">
        <fieldset>
            <legend>
                Info
            </legend>
            Status: <?= $task->isActive()? 'aktiv': 'pausiert' ?> |
            <?= $task->isNotify() ? 'wird benachrichtigt' : 'wird nicht benachrichtigt' ?><br />


            Interval: <?= \DoEveryApp\Util\View\IntervalHelper::get($task) ?>
            <? if(null !== $task->getIntervalType()): ?>
                (<?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByTask($task) ?>)
            <? endif ?>
            |

            Priorität: <?= \DoEveryApp\Util\View\PriorityMap::getByTask($task) ?><br />

            es arbeitet gerade daran: <?= null === $task->getWorkingOn()? 'niemand': \DoEveryApp\Util\View\Worker::get($task->getWorkingOn()) ?> |
            zugewiesen an: <?= null === $task->getAssignee()? 'niemand': \DoEveryApp\Util\View\Worker::get($task->getAssignee()) ?><br />
            letzte Ausführung: <?= $lastExecution ? \DoEveryApp\Util\View\ExecutionDate::byExecution($lastExecution) : '-' ?>
            <? if(null !== $lastExecution && null !== $lastExecution->getWorker()): ?>
                von <?= \DoEveryApp\Util\View\Worker::get($lastExecution->getWorker()) ?>
            <? endif ?>
        </fieldset>

    </div>
    <? if(0 !== sizeof($executions)): ?>
        <div class="column">
            <?= $this->fetchTemplate('partial/durations.php', ['durations' => $durations]) ?>
        </div>
    <? endif ?>
</div>

<hr>

<div class="row">
    <? if(null !== $task->getNote()): ?>
        <div class="column">
            <?= \DoEveryApp\Util\View\TaskNote::byTask($task) ?>
        </div>
    <? endif ?>
    <? if(0 !== sizeof($task->getCheckListItems())): ?>
        <div class="column">
            <fieldset>
                <legend>
                    Aufgabenliste
                </legend>
                <table>
                    <thead>
                    <tr>
                        <th>
                            Step
                        </th>
                        <th>
                            Hinweis
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($task->getCheckListItems() as $checkListItem): ?>
                        <tr>
                            <td>
                                <?= \DoEveryApp\Util\View\Escaper::escape($checkListItem->getName()) ?>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\CheckListItemNote::byTaskCheckListItem($checkListItem) ?>
                            </td>
                        </tr>
                    <? endforeach ?>
                    </tbody>
                </table>
            </fieldset>


        </div>
    <? endif ?>
</div>




<? if(0 !== sizeof($executions)): ?>
    <hr />
    <fieldset>
        <legend>Ausführungen</legend>

        <table>
            <thead>
                <tr>
                    <th>
                        Datum
                    </th>
                    <th>
                        <?= $translator->worker() ?>
                    </th>
                    <th>
                        Dauer
                    </th>
                    <? if(0 !== sizeof($task->getCheckListItems())): ?>
                        <th>
                            Steps
                        </th>
                    <? endif ?>
                    <th>
                        Notiz
                    </th>
                    <th class="pullRight">
                        Aktionen
                    </th>
                </tr>
            </thead>
            <tbody>
                <? foreach($task->getExecutions() as $execution): ?>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\ExecutionDate::byExecution($execution) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get($execution->getWorker()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Duration::byExecution($execution) ?>
                        </td>
                        <? if(0 !== sizeof($task->getCheckListItems())): ?>
                            <td>

                                <? foreach($execution->getCheckListItems() as $checkListItem): ?>

                                    <div class="row">
                                        <div class="column">
                                            <?= \DoEveryApp\Util\View\CheckListItem::byExecutionCheckListItem($checkListItem) ?>
                                        </div>
                                        <div class="column">
                                            <?= \DoEveryApp\Util\View\ExecutionNote::byValue($checkListItem->getNote()) ?>
                                        </div>
                                    </div>
                                <? endforeach ?>
                            </td>
                        <? endif ?>

                        <td>
                            <?= \DoEveryApp\Util\View\ExecutionNote::byExecution($execution) ?>
                        </td>
                        <td class="pullRight">
                            <div class="buttonRow">
                                <a class="primaryButton" href="<?= \DoEveryApp\Action\Execution\EditAction::getRoute($execution->getId()) ?>">
                                    <?= $this->fetchTemplate('icon/edit.php') ?>
                                    bearbeiten
                                </a>
                                <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Execution\DeleteAction::getRoute($execution->getId()) ?>">
                                    <?= $this->fetchTemplate('icon/trash.php') ?>
                                    löschen
                                </a>
                            </div>
                        </td>
                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    </fieldset>
<? endif ?>
