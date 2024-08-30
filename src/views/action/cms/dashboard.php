<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $tasks             \DoEveryApp\Entity\Task[]
 * @var $tasksWithoutGroup \DoEveryApp\Entity\Task[]
 * @var $groups            \DoEveryApp\Entity\Group[]
 * @var $workers           \DoEveryApp\Entity\Worker[]
 */
?>

<h1>
    Dashboard
</h1>
<div class="cards">

    <? foreach($groups as $group): ?>
        <div class="groupContainer">
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
        <div class="taskContainer">
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
                ID
            </th>
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
                    <?= $task->getId() ?>
                </td>
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
                    [E]
                    [X]
                </td>
            </tr>
        <? endforeach ?>
    </tbody>
</table>
