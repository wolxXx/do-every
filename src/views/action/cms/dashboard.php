<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $executions             \DoEveryApp\Entity\Execution[]
 * @var $tasks                  \DoEveryApp\Entity\Task[]
 * @var $tasksWithoutGroup      \DoEveryApp\Entity\Task[]
 * @var $groups                 \DoEveryApp\Entity\Group[]
 * @var $workers                \DoEveryApp\Entity\Worker[]
 */
$durations = \DoEveryApp\Definition\Durations::FactoryForGlobal();
?>

<h1>
    Dashboard
</h1>
<div class="cards row">

    <? foreach($groups as $group): ?>
        <div class="groupContainer column">
            <?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?><br />
            <?= sizeof($group->getActiveTasks()) ?> aktive Aufgaben,<br />
            <?= sizeof($group->getInActiveTasks()) ?> pausierte Aufgaben<br />
            <br />
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($group->getId()) ?>">
                anzeigen
            </a>
        </div>
    <? endforeach ?>

    <? foreach($tasksWithoutGroup as $task): ?>
        <div class="taskContainer column">
            <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?><br />
            <br />
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                anzeigen
            </a>
        </div>
    <? endforeach ?>
</div>
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
                Intervall
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
                    <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\IntervalHelper::get($task) ?>
                </td>
                <td>
                    <? if(null === $task->getAssignee()): ?>
                        -
                    <? else: ?>
                        <?= \DoEveryApp\Util\View\Escaper::escape($task->getAssignee()->getName()) ?>
                    <? endif ?>
                </td>
                <td>
                    <? if(null === $task->getWorkingOn()): ?>
                        -
                    <? else: ?>
                        <?= \DoEveryApp\Util\View\Escaper::escape($task->getWorkingOn()->getName()) ?>
                    <? endif ?>
                </td>
                <td>
                    <?= \DoEveryApp\Util\View\DateTime::getDateTime($lastExecution) ?>
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
<h2>Ausführungen</h2>

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
            <? foreach($executions as $execution): ?>
                <tr>
                    <td>
                        <?= \DoEveryApp\Util\View\DateTime::getDateTime($execution->getDate()) ?>
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
                        <?= \DoEveryApp\Util\View\Escaper::escape($execution->getTask()->getName()) ?>
                    </td>
                    <td>
                        <?= \DoEveryApp\Util\View\Duration::byExecution($execution) ?>
                    </td>
                    <td>
                        <? if(null === $execution->getWorker()): ?>
                            -
                        <? endif?>
                        <? if(null !== $execution->getWorker()): ?>
                            <?= \DoEveryApp\Util\View\Escaper::escape($execution->getWorker()->getName()) ?>
                        <? endif?>
                    </td>
                    <td>
                        <?= nl2br(\DoEveryApp\Util\View\Escaper::escape($execution->getNote())) ?>
                    </td>
                </tr>
            <? endforeach ?>
            </tbody>
        </table>

    </div>
    <div class="column">


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
    </div>
</div>


