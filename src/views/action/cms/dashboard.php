<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $executions                \DoEveryApp\Entity\Execution[]
 * @var $dueTasks                  \DoEveryApp\Entity\Task[]
 * @var $tasks                     \DoEveryApp\Entity\Task[]
 * @var $tasksWithoutGroup         \DoEveryApp\Entity\Task[]
 * @var $groups                    \DoEveryApp\Entity\Group[]
 * @var $workers                   \DoEveryApp\Entity\Worker[]
 * @var $workingOn                 \DoEveryApp\Entity\Task[]
 */
$durations = \DoEveryApp\Definition\Durations::FactoryForGlobal();
?>

<h1>
    Dashboard
</h1>

<? if(0 !== sizeof($workingOn)): ?>
    <h3>
        Aktuelle Arbeiten
    </h3>
    <table style="margin-bottom: 50px;">
        <thead>
            <tr>
                <th>
                    Aufgabe
                </th>
                <th>
                    arbeitet daran
                </th>
                <th>
                    zugewiesen an
                </th>
            </tr>
        </thead>
        <tbody>
            <? foreach($workingOn as $workingOnTask): ?>
                <tr>
                    <td>
                        <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($workingOnTask->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Escaper::escape($workingOnTask->getName()) ?>
                            <? if(null !== $workingOnTask->getGroup()): ?>
                                (<?= \DoEveryApp\Util\View\Escaper::escape($workingOnTask->getGroup()->getName()) ?>)
                            <? endif ?>
                        </a>
                    </td>
                    <td>
                        <?= \DoEveryApp\Util\View\Worker::get($workingOnTask->getWorkingOn()) ?>
                    </td>
                    <td>
                        <?= \DoEveryApp\Util\View\Worker::get($workingOnTask->getAssignee()) ?>
                    </td>
                </tr>
            <? endforeach ?>
        </tbody>
    </table>
<? endif ?>

<? if(0 !== sizeof($dueTasks)): ?>
    <h2>
        Fällige Aufgaben
    </h2>
    <div style="margin-bottom: 50px;" class="row">
        <? foreach($dueTasks as $task): ?>
            <div class="column">
                <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                    <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>:
                    <?= \DoEveryApp\Util\View\Due::getByTask($task) ?>
                </a>
            </div>
        <? endforeach ?>
    </div>
<? endif ?>

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
                zugewiesen an 
            </th>
            <th>
                arbeitet daran 
            </th>
            <th>
                letzte Ausführung 
            </th>
            <th>
                Fälligkeit
            </th>
            <th>
                Intervall
            </th>
            <th>
                Aktionen 
            </th>
        </tr>
    </thead>
    <tbody>
        <? foreach($tasks as $task): ?>
            <?
            $lastExecution = $task::getRepository()->getLastExecution($task)?->getDate();
            ?>
            <tr>
                <td>
                    <? if(null === $task->getGroup()): ?>
                        -
                    <? else: ?>
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
                    <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime($lastExecution) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\Due::getByTask($task) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\IntervalHelper::get($task) ?>
                </td>
                <td>
                    <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                        [S]
                    </a>
                    <a href="<?= \DoEveryApp\Action\Execution\AddAction::getRoute($task->getId()) ?>">
                        [T]
                    </a>
                    <a href="<?= \DoEveryApp\Action\Task\EditAction::getRoute($task->getId()) ?>">
                        [E]
                    </a>
                    <a class="confirm" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute($task->getId()) ?>">
                        [X]
                    </a>
                </td>
            </tr>
        <? endforeach ?>
    </tbody>
</table>

<hr>
<h2>
    Ausführungen
</h2>

<div class="row">
    <div class="column">
        <table>
            <thead>
            <tr>
                <th>
                    Datum
                </th>
                <th>
                    Gruppe
                </th>
                <th>
                    Aufgabe
                </th>
                <th>
                    Aufwand
                </th>
                <th>
                    Worker
                </th>
                <th>
                    Notiz
                </th>
            </tr>
            </thead>
            <tbody>
            <? foreach(array_slice($executions, 0, 10) as $execution): ?>
                <tr>
                    <td>
                        <?= \DoEveryApp\Util\View\ExecutionDate::byExecution($execution) ?>
                    </td>
                    <td>
                        <? if(null === $execution->getTask()->getGroup()): ?>
                            -
                        <? endif?>
                        <? if(null !== $execution->getTask()->getGroup()): ?>
                            <?= \DoEveryApp\Util\View\Escaper::escape($execution->getTask()->getGroup()->getName()) ?>
                        <? endif?>
                    </td>
                    <td>
                        <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($execution->getTask()->getId()) ?>">
                            <?= \DoEveryApp\Util\View\Escaper::escape($execution->getTask()->getName()) ?>
                        </a>
                    </td>
                    <td>
                        <?= \DoEveryApp\Util\View\Duration::byExecution($execution) ?>
                    </td>
                    <td>
                        <?= \DoEveryApp\Util\View\Worker::get($execution->getWorker()) ?>
                    </td>
                    <td>
                        <?= \DoEveryApp\Util\View\ExecutionNote::byExecution($execution) ?>
                    </td>
                </tr>
            <? endforeach ?>
            </tbody>
        </table>

    </div>
    <div class="column">
        <?= $this->fetchTemplate('partial/durations.php', ['durations' => $durations]) ?>
    </div>
</div>


