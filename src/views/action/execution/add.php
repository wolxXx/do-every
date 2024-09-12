<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 */

/**
 * @var $task            \DoEveryApp\Entity\Task
 * @var $data            array
 */

?>


<h1>
    Ausführung hinzufügen
</h1>
<div>
    <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
        Aufgabe: <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
    </a>
    <? if(null !== $task->getGroup()): ?>
        |  Gruppe:
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($task->getGroup()->getId()) ?>">
            <?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>
        </a>
    <? endif ?>
</div>

<?= $this->fetchTemplate('action/execution/partial/addEdit.php', ['data' => $data]) ?>
