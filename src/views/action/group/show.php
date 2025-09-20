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
    <?= \DoEveryApp\Util\View\Escaper::escape(value: $group->getName()) ?>
</h1>
<div class="pageButtons buttonRow">
    <a href="<?= \DoEveryApp\Action\Task\AddAction::getRoute() ?>?group=<?= $group->getId() ?>" class="primaryButton">
        <?= \DoEveryApp\Util\View\Icon::add() ?>
        <?= $translator->addTask() ?>
    </a>
    <a href="<?= \DoEveryApp\Action\Group\EditAction::getRoute(id: $group->getId()) ?>" class="warningButton">
        <?= \DoEveryApp\Util\View\Icon::edit() ?>
        <?= $translator->edit() ?>
    </a>
    <a class="dangerButton confirm" data-message="<?= \DoEveryApp\Util\View\Escaper::escape(value: $translator->reallyWantToDeleteGroup(name: $group->getName())) ?>" href="<?= \DoEveryApp\Action\Group\DeleteAction::getRoute(id: $group->getId()) ?>">
        <?= \DoEveryApp\Util\View\Icon::trash() ?>
        <?= $translator->delete() ?>
    </a>
</div>

<div class="row">
    <div class="column">
        <div class="grid">
            <?php foreach($group->getTasks() as $task): ?>
                <div class="column card">
                    <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) ?><br />
                    <?= \DoEveryApp\Util\View\Due::getByTask(task: $task) ?><br />
                    <?php if(null !== $task->getWorkingOn()): ?>
                        <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getWorkingOn()->getName()) ?> <?= $translator->currentlyWorkingOn() ?><br />
                    <?php endif ?>
                    <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
                        <?= $translator->show() ?>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="column">
        <?= $this->fetchTemplate(template: 'partial/durations.php', data: ['durations' => \DoEveryApp\Definition\Durations::FactoryByGroup(group: $group)]) ?>
    </div>
</div>
