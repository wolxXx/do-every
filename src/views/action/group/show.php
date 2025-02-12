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
 * @var \DoEveryApp\Entity\Group $group
 */
?>

<h1>
    <?= $translator->group() ?>
    <?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?>
</h1>
<div class="pageButtons buttonRow">
    <a href="<?= \DoEveryApp\Action\Task\AddAction::getRoute() ?>?group=<?= $group->getId() ?>" class="primaryButton">
        <?= $translator->addTask() ?>
    </a>
    <a href="<?= \DoEveryApp\Action\Group\EditAction::getRoute($group->getId()) ?>" class="warningButton">
        <?= $translator->edit() ?>
    </a>
    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Group\DeleteAction::getRoute($group->getId()) ?>">
        <?= $translator->delete() ?>
    </a>
</div>

<div class="row">
    <div class="column">
        <div class="grid">
            <?php foreach($group->getTasks() as $task): ?>
                <div class="column card">
                    <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?><br />
                    <?= \DoEveryApp\Util\View\Due::getByTask($task) ?><br />
                    <?php if(null !== $task->getWorkingOn()): ?>
                        <?= \DoEveryApp\Util\View\Escaper::escape($task->getWorkingOn()->getName()) ?> <?= $translator->currentlyWorkingOn() ?><br />
                    <?php endif ?>
                    <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                        <?= $translator->show() ?>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="column">
        <?= $this->fetchTemplate('partial/durations.php', ['durations' => \DoEveryApp\Definition\Durations::FactoryByGroup($group)]) ?>
    </div>
</div>
