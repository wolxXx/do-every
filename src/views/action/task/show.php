<?php
declare(strict_types=1);
/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $task            \DoEveryApp\Entity\Task
 */
$lastExecution = $task::getRepository()->getLastExecution($task);
?>

<h1>
    Aufgabe <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
    <? if(null !== $task->getGroup()): ?>
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($task->getGroup()->getId()) ?>">
            (<?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>)
        </a>
    <? endif ?>
</h1>
Interval: <?= \DoEveryApp\Util\View\IntervalHelper::get($task) ?><br />
Priorität: <?= \DoEveryApp\Util\View\PriorityMap::getByTask($task) ?><br />
Status: <?= $task->isActive()? 'aktiv': 'pausiert' ?><br />
zugewiesen an: <?= null === $task->getAssignee()? 'niemand': \DoEveryApp\Util\View\Escaper::escape($task->getAssignee()->getName()) ?><br />
es arbeitet gerade daran: <?= null === $task->getWorkingOn()? 'niemand': \DoEveryApp\Util\View\Escaper::escape($task->getWorkingOn()->getName()) ?><br />
letzte Ausführung: <?= \DoEveryApp\Util\View\DateTime::getDateTime($lastExecution?->getDate()) ?>
<? if(null !== $lastExecution && null !== $lastExecution->getWorker()): ?>
    von <?= \DoEveryApp\Util\View\Escaper::escape($lastExecution->getWorker()->getName()) ?>
<? endif ?>
