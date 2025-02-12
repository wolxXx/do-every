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
                    <? foreach($tasks as $task): ?>
                        <tr>
                            <td>
                                <? if(null === $task->getGroup()): ?>
                                    <?= $translator->noValue() ?>
                                <? endif ?>
                                <? if(null !== $task->getGroup()): ?>
                                    <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($task->getGroup()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>
                                    </a>
                                <? endif ?>
                            </td>
                            <td>
                                <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
                                </a>
                            </td>
                            <td>
                                <? if(null !== $task->getAssignee()): ?>
                                    <a href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute($task->getAssignee()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Worker::get($task->getAssignee()) ?>
                                    </a>
                                <? endif ?>
                                <? if(null === $task->getAssignee()): ?>
                                    <?= \DoEveryApp\Util\View\Worker::get($task->getAssignee()) ?>
                                <? endif ?>
                            </td>
                            <td>
                                <? if(null !== $task->getWorkingOn()): ?>
                                    <a href="<?= \DoEveryApp\Action\Worker\LogAction::getRoute($task->getWorkingOn()->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Worker::get($task->getWorkingOn()) ?>
                                    </a>
                                <? endif ?>
                                <? if(null === $task->getWorkingOn()): ?>
                                    <?= \DoEveryApp\Util\View\Worker::get($task->getWorkingOn()) ?>
                                <? endif ?>
                            </td>
                            <td>
                                <?= $translator->priority() ?>: <?= \DoEveryApp\Util\View\PriorityMap::getByTask($task) ?><br />
                                <?= $translator->doNotifyDueTasksQuestion() ?> <?= \DoEveryApp\Util\View\Boolean::get($task->isNotify()) ?><br />
                                <?= \DoEveryApp\Util\View\Due::getByTask($task) ?><br />
                                <?= $translator->lastExecution() ?>: <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(\DoEveryApp\Entity\Task::getRepository()->getLastExecution($task)?->getDate()) ?><br />
                                <?= $translator->active() ?>: <?= \DoEveryApp\Util\View\Boolean::get($task->isActive()) ?><br />
                                <?= $translator->effort() ?>: <?= \DoEveryApp\Util\View\Duration::byValue(array_sum(array_map(function(\DoEveryApp\Entity\Execution $execution) {
                                    return $execution->getDuration() ?? 0;
                                }, $task->getExecutions()))) ?> (<?= count($task->getExecutions()) ?> <?= $translator->executions() ?>)

                            </td>
                            <td class="pullRight">
                                <nobr class="buttonRow">
                                    <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::show() ?>
                                    </a>
                                    <a class="warningButton" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute($task->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::edit() ?>
                                    </a>
                                    <? if (true === $task->isActive()): ?>
                                        <a class="warningButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute($task->getId(), false) ?>">
                                            <?= \DoEveryApp\Util\View\Icon::off() ?>
                                        </a>
                                    <? endif ?>
                                    <? if (false === $task->isActive()): ?>
                                        <a class="successButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute($task->getId(), true) ?>">
                                            <?= \DoEveryApp\Util\View\Icon::on() ?>
                                        </a>
                                    <? endif ?>

                                    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\ResetAction::getRoute($task->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::refresh() ?>
                                    </a>
                                    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute($task->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::trash() ?>
                                    </a>
                                </nobr>
                            </td>
                        </tr>
                    <? endforeach ?>
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
                    <? foreach(\DoEveryApp\Entity\Group::getRepository()->findIndexed() as $group): ?>
                        <tr>
                            <td>
                                <?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?>
                            </td>
                            <td class="pullRight">
                                <div class="buttonRow">
                                    <a class="primaryButton" href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($group->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::show() ?>
                                    </a>
                                    <a class="warningButton" href="<?= \DoEveryApp\Action\Group\EditAction::getRoute($group->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::edit() ?>
                                    </a>
                                    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Group\DeleteAction::getRoute($group->getId()) ?>">
                                        <?= \DoEveryApp\Util\View\Icon::trash() ?>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <? endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>