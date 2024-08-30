<?php
declare(strict_types=1);
/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $group            \DoEveryApp\Entity\Group
 */
?>

<h1>
    Gruppe <?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?>
</h1>

<div class="cards">
    <? foreach($group->getTasks() as $task): ?>
        <div class="taskContainer">
            <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?><br />
            <br />
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                anzeigen
            </a>
        </div>
    <? endforeach ?>
</div>