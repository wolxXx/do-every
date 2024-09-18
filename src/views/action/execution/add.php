<?php

declare(strict_types=1);

/**
 * @var \Slim\Views\PhpRenderer        $this
 * @var \DoEveryApp\Util\ErrorStore    $errorStore
 * @var string                         $currentRoute
 * @var string                         $currentRoutePattern
 * @var \DoEveryApp\Entity\Worker|null $currentUser
 * @var \DoEveryApp\Util\Translator    $translator
 */

/**
 * @var \DoEveryApp\Entity\Task $task
 * @var array                   $data
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
    <hr />
</div>

<?= $this->fetchTemplate('action/execution/partial/addEdit.php', ['data' => $data]) ?>
