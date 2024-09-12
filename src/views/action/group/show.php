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
 * @var $group            \DoEveryApp\Entity\Group
 */
?>

<h1>
    Gruppe <?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?>
</h1>
<div class="pageButtons buttonRow">
    <a href="<?= \DoEveryApp\Action\Task\AddAction::getRoute() ?>?group=<?= $group->getId() ?>" class="primaryButton">
        neue Aufgabe
    </a>
    <a href="<?= \DoEveryApp\Action\Group\EditAction::getRoute($group->getId()) ?>" class="primaryButton">
        bearbeiten
    </a>
    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Group\DeleteAction::getRoute($group->getId()) ?>">
        löschen
    </a>
</div>

<div class="grid">
    <? foreach($group->getTasks() as $task): ?>
        <div class="column card">
            <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?><br />
            <?= \DoEveryApp\Util\View\Due::getByTask($task) ?><br />
            <? if(null !== $task->getWorkingOn()): ?>
                <?= \DoEveryApp\Util\View\Escaper::escape($task->getWorkingOn()->getName()) ?> arbeitet daran<br />
            <? endif ?>
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                anzeigen
            </a>
        </div>
    <? endforeach ?>
</div>