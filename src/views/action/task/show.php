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
?>

<h1>
    Aufgabe <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
    <? if (null !== $task->getGroup()): ?>
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($task->getGroup()->getId()) ?>">
            (<?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>)
        </a>
    <? endif ?>
</h1>


<div>
    <a class="primaryButton">
        starten
    </a>
    <a class="primaryButton">
        stoppen    
    </a>
    <a class="primaryButton">
        bearbeiten
    </a>
    <a class="primaryButton">
        löschen
    </a>
</div>

<hr />
Status: <?= $task->isActive()? 'aktiv': 'pausiert' ?> |
<?= $task->isNotify() ? 'wird benachrichtigt' : 'wird nicht benachrichtigt' ?><br />


Interval: <?= \DoEveryApp\Util\View\IntervalHelper::get($task) ?> | 
Priorität: <?= \DoEveryApp\Util\View\PriorityMap::getByTask($task) ?><br />

zugewiesen an: <?= null === $task->getAssignee()? 'niemand': \DoEveryApp\Util\View\Escaper::escape($task->getAssignee()->getName()) ?> | 
es arbeitet gerade daran: <?= null === $task->getWorkingOn()? 'niemand': \DoEveryApp\Util\View\Escaper::escape($task->getWorkingOn()->getName()) ?><br />
letzte Ausführung: <?= \DoEveryApp\Util\View\DateTime::getDateTime($lastExecution?->getDate()) ?>
<? if(null !== $lastExecution && null !== $lastExecution->getWorker()): ?>
    von <?= \DoEveryApp\Util\View\Escaper::escape($lastExecution->getWorker()->getName()) ?>
<? endif ?>
<hr />
<div>
    <form action="" method="post" novalidate>
        <div>
            <input type="number" name="duration" value="10" />
        </div>
        <div>
            <input class="primaryButton" type="submit" value="hinzufügen" />
        </div>
    </form>
</div>
<div>
    
    <? if(0 === sizeof($executions)): ?>
        - bisher nicht ausgeführt -
    <? endif ?>
    <? if(0 !== sizeof($executions)): ?>
        <? foreach($task->getExecutions() as $execution): ?>
            <?=  $execution->getId() ?>
        <? endforeach ?>
    <? endif ?>

</div>