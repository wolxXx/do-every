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
 * @var \DoEveryApp\Entity\Task[] $tasks
 */
?>

<div class="row">
    <div class="column">
        <h1>
            <?= $translator->tasks() ?>
        </h1>
        <div class="pageButtons">
            <a href="<?= \DoEveryApp\Action\Task\AddAction::getRoute() ?>" class="primaryButton">
                <?= \DoEveryApp\Util\View\Icon::add() ?>
            </a>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>
                            <?= $translator->group() ?>
                        </th>
                        <th>
                            <?= $translator->name() ?>
                        </th>
                        <th>
                            <?= $translator->assignedTo() ?>
                        </th>
                        <th>
                            <?= $translator->currentlyWorkingOn() ?>
                        </th>
                        <th>
                            <?= $translator->info() ?>
                        </th>
                        <th class="pullRight">
                            <?= $translator->actions() ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tasks as $task): ?>
                        <tr>
                            <td>
                                <?php if(null === $task->getGroup()): ?>
                                    <?= $translator->noValue() ?>
                                <?php endif ?>
                                <?php if(null !== $task->getGroup()): ?>
                                    <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute(id: $task->getGroup()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) ?>
                                    </a>
                                <?php endif ?>
                            </td>
                            <td>
                                <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) ?>
                                </a>
                            </td>
                            <td>
                                <?php if(null !== $task->getAssignee()): ?>
                                    <a href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute(id: $task->getAssignee()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Worker::get(worker: $task->getAssignee()) ?>
                                    </a>
                                <?php endif ?>
                                <?php if(null === $task->getAssignee()): ?>
                                    <?= \DoEveryApp\Util\View\Worker::get(worker: $task->getAssignee()) ?>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php if(null !== $task->getWorkingOn()): ?>
                                    <a href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute(id: $task->getWorkingOn()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Worker::get(worker: $task->getWorkingOn()) ?>
                                    </a>
                                <?php endif ?>
                                <?php if(null === $task->getWorkingOn()): ?>
                                    <?= \DoEveryApp\Util\View\Worker::get(worker: $task->getWorkingOn()) ?>
                                <?php endif ?>
                            </td>
                            <td>
                                <?= $translator->priority() ?>: <?= \DoEveryApp\Util\View\PriorityMap::getByTask(task: $task) ?><br />
                                <?= $translator->doNotifyDueTasksQuestion() ?> <?= \DoEveryApp\Util\View\Boolean::get(value: $task->isNotify()) ?><br />
                                <?= \DoEveryApp\Util\View\Due::getByTask(task: $task) ?><br />
                                <?= $translator->lastExecution() ?>: <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(dateTime: \DoEveryApp\Entity\Task::getRepository()->getLastExecution(task: $task)?->getDate()) ?><br />
                                <?= $translator->active() ?>: <?= \DoEveryApp\Util\View\Boolean::get(value: $task->isActive()) ?><br />
                                <?= $translator->effort() ?>: <?= \DoEveryApp\Util\View\Duration::byValue(duration: array_sum(array: array_map(callback: function (\DoEveryApp\Entity\Execution $execution) {
                                    return $execution->getDuration() ?? 0;
                                }, array: $task->getExecutions()))) ?> (<?= count(value: $task->getExecutions()) ?> <?= $translator->executions() ?>)

                            </td>
                            <td class="pullRight">
                                <nobr class="buttonRow">
                                    <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::show() ?>
                                    </a>
                                    <a class="warningButton" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute(id: $task->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::edit() ?>
                                    </a>
                                    <?php if (true === $task->isActive()): ?>
                                        <a class="warningButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute(id: $task->getId(), active: false) ?>">
                                            <?= \DoEveryApp\Util\View\Icon::off() ?>
                                        </a>
                                    <?php endif ?>
                                    <?php if (false === $task->isActive()): ?>
                                        <a class="successButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute(id: $task->getId(), active: true) ?>">
                                            <?= \DoEveryApp\Util\View\Icon::on() ?>
                                        </a>
                                    <?php endif ?>

                                    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\ResetAction::getRoute(id: $task->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::refresh() ?>
                                    </a>
                                    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute(id: $task->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::trash() ?>
                                    </a>
                                </nobr>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="column">
        <h1>
            <?= $translator->groups() ?>
        </h1>
        <div class="pageButtons">
            <a href="<?= \DoEveryApp\Action\Group\AddAction::getRoute() ?>" class="primaryButton">
                <?= \DoEveryApp\Util\View\Icon::add() ?>
            </a>
        </div>
        <div>
            <table>
                <thead>
                <tr>
                    <th>
                        <?= $translator->name() ?>
                    </th>
                    <th class="pullRight">
                        <?= $translator->actions() ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach(\DoEveryApp\Entity\Group::getRepository()->findIndexed() as $group): ?>
                        <tr>
                            <td>
                                <?= \DoEveryApp\Util\View\Escaper::escape(value: $group->getName()) ?>
                            </td>
                            <td class="pullRight">
                                <div class="buttonRow">
                                    <a class="primaryButton" href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute(id: $group->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::show() ?>
                                    </a>
                                    <a class="warningButton" href="<?= \DoEveryApp\Action\Group\EditAction::getRoute(id: $group->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::edit() ?>
                                    </a>
                                    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Group\DeleteAction::getRoute(id: $group->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::trash() ?>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>