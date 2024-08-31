<?php

declare(strict_types=1);
/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 * @var $currentUser  \DoEveryApp\Entity\Worker|null
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


<div>
    <? if(null === $task->getWorkingOn()): ?>
        <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\MarkWorkingAction::getRoute($task->getId(), $currentUser->getId()) ?>">
            ich arbeite daran
        </a>
    <? endif ?>
    <? if(null !== $task->getWorkingOn()): ?>
        <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\MarkWorkingAction::getRoute($task->getId()) ?>">
            niemand arbeitet daran
        </a>
    <? endif ?>

    <a class="primaryButton" href="<?= \DoEveryApp\Action\Execution\AddAction::getRoute($task->getId()) ?>">
        Ausführung eintragen
    </a>
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute($task->getId()) ?>">
        bearbeiten
    </a>
    <a class="warningButton confirm" href="<?= \DoEveryApp\Action\Task\ResetAction::getRoute($task->getId()) ?>">
        reset
    </a>
    <? if(true === $task->isActive()): ?>
        <a class="warningButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute($task->getId(), false) ?>">
            deaktivieren
        </a>
    <? endif ?>
    <? if(false === $task->isActive()): ?>
        <a class="warningButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute($task->getId(), true) ?>">
            aktivieren
        </a>
    <? endif ?>

    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute($task->getId()) ?>">
        löschen
    </a>
</div>

<hr />

<div class="row">
    <div class="column">
        Status: <?= $task->isActive()? 'aktiv': 'pausiert' ?> |
        <?= $task->isNotify() ? 'wird benachrichtigt' : 'wird nicht benachrichtigt' ?><br />


        Interval: <?= \DoEveryApp\Util\View\IntervalHelper::get($task) ?> |
        Priorität: <?= \DoEveryApp\Util\View\PriorityMap::getByTask($task) ?><br />

        es arbeitet gerade daran: <?= null === $task->getWorkingOn()? 'niemand': \DoEveryApp\Util\View\Escaper::escape($task->getWorkingOn()->getName()) ?> |
        zugewiesen an: <?= null === $task->getAssignee()? 'niemand': \DoEveryApp\Util\View\Escaper::escape($task->getAssignee()->getName()) ?><br />
        letzte Ausführung: <?= \DoEveryApp\Util\View\DateTime::getDateTime($lastExecution?->getDate()) ?>
        <? if(null !== $lastExecution && null !== $lastExecution->getWorker()): ?>
            von <?= \DoEveryApp\Util\View\Escaper::escape($lastExecution->getWorker()->getName()) ?>
        <? endif ?>
    </div>
    <div class="column">

        <? if(0 === sizeof($executions)): ?>
            - bisher nicht ausgeführt -
        <? endif ?>
        <? if(0 !== sizeof($executions)): ?>
            Aufwand durchschnittlich: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getAverage()) ?>,
            insgesamt: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getTotal()) ?><br />

            heute: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getDay()) ?>,
            gestern: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastDay()) ?><br />

            diese Woche: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getWeek()) ?>,
            letzte Woche: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastWeek()) ?><br />

            dieser Monat: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getMonth()) ?>,
            letzter Monat: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastMonth()) ?><br />

            dieses Jahr: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getYear()) ?>,
            letztes Jahr: <?= \DoEveryApp\Util\View\Duration::byValue($durations->getLastYear()) ?><br />
        <? endif ?>
    </div>
</div>

<hr />

<div>
    <? if(0 !== sizeof($executions)): ?>
            <table>
            <thead>
                <tr>
                    <th>
                        Datum
                    </th>
                    <th>
                        Worker
                    </th>
                    <th>
                        Dauer
                    </th>
                    <th>
                        Notiz
                    </th>
                    <th>
                        Aktionen
                    </th>
                </tr>
            </thead>
            <tbody>
                <? foreach($task->getExecutions() as $execution): ?>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\DateTime::getDateTime($execution->getDate()) ?>
                        </td>
                        <td>
                            <?= null !== $execution->getWorker()? \DoEveryApp\Util\View\Escaper::escape($execution->getWorker()->getName()): '-' ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Duration::byExecution($execution) ?>
                        </td>
                        <td>
                            <?= null !== $execution->getNote()? nl2br(\DoEveryApp\Util\View\Escaper::escape($execution->getNote())): '-' ?>
                        </td>
                        <td>
                            <a class="primaryButton confirm" href="<?= \DoEveryApp\Action\Execution\EditAction::getRoute($execution->getId()) ?>">
                                bearbeiten
                            </a>
                            <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Execution\DeleteAction::getRoute($execution->getId()) ?>">
                                löschen
                            </a>
                        </td>
                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    <? endif ?>

</div>