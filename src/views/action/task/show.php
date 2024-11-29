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
 */
$lastExecution = $task::getRepository()->getLastExecution($task);
$executions    = $task->getExecutions();
$durations     = \DoEveryApp\Definition\Durations::FactoryByTask($task);
?>

<h1>
    <?= $translator->task() ?>: <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
    <? if (null !== $task->getGroup()): ?>
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($task->getGroup()->getId()) ?>">
            (<?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>)
        </a>
    <? endif ?>
</h1>

<h2>
    <?= \DoEveryApp\Util\View\Due::getByTask($task) ?>
</h2>

<div class="pageButtons buttonRow">
    <? if(null === $task->getWorkingOn()): ?>
        <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\MarkWorkingAction::getRoute($task->getId(), $currentUser->getId()) ?>">
            <?= \DoEveryApp\Util\View\Icon::hand() ?>
            <?= $translator->iAmWorkingOn() ?>
        </a>
    <? endif ?>
    <? if(null !== $task->getWorkingOn()): ?>
        <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\MarkWorkingAction::getRoute($task->getId()) ?>">
            <?= \DoEveryApp\Util\View\Icon::cross() ?>
            <?= $translator->nobodyIsWorkingOn() ?>
        </a>
    <? endif ?>

    <a class="primaryButton" href="<?= \DoEveryApp\Action\Execution\AddAction::getRoute($task->getId()) ?>">
        <?= \DoEveryApp\Util\View\Icon::add() ?>
        <?= $translator->addExecution() ?>
    </a>
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute($task->getId()) ?>">
        <?= \DoEveryApp\Util\View\Icon::edit() ?>
        <?= $translator->edit() ?>
    </a>
    <a class="warningButton confirm" href="<?= \DoEveryApp\Action\Task\ResetAction::getRoute($task->getId()) ?>">
        <?= \DoEveryApp\Util\View\Icon::refresh() ?>
        <?= $translator->reset() ?>

    </a>
    <? if(true === $task->isActive()): ?>
        <a class="warningButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute($task->getId(), false) ?>">
            <?= \DoEveryApp\Util\View\Icon::off() ?>
            <?= $translator->deactivate() ?>
        </a>
    <? endif ?>
    <? if(false === $task->isActive()): ?>
        <a class="successButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute($task->getId(), true) ?>">
            <?= \DoEveryApp\Util\View\Icon::on() ?>
            <?= $translator->activate() ?>
        </a>
    <? endif ?>

    <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute($task->getId()) ?>">
        <?= \DoEveryApp\Util\View\Icon::trash() ?>
        <?= $translator->delete() ?>
    </a>
</div>

<hr />

<div class="row">
    <div class="column">
        <fieldset>
            <legend>
                <?= $translator->info() ?>
            </legend>
            <?= $translator->status() ?>: <?= $task->isActive()? $translator->active(): $translator->paused() ?> |
            <?= $task->isNotify() ? $translator->willBeNotified() : $translator->willNotBeNotified() ?><br />


            <?= $translator->interval() ?>: <?= \DoEveryApp\Util\View\IntervalHelper::get($task) ?>
            <? if(null !== $task->getIntervalType()): ?>
                (<?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByTask($task) ?>)
            <? endif ?>
            |

            <?= $translator->priority() ?>: <?= \DoEveryApp\Util\View\PriorityMap::getByTask($task) ?><br />

            <?= $translator->currentlyWorkingOn() ?>: <?= null === $task->getWorkingOn()? $translator->nobody(): \DoEveryApp\Util\View\Worker::get($task->getWorkingOn()) ?> |
            <?= $translator->assignedTo() ?>: <?= null === $task->getAssignee()? $translator->nobody(): \DoEveryApp\Util\View\Worker::get($task->getAssignee()) ?><br />
            <?= $translator->lastExecution() ?>: <?= $lastExecution ? \DoEveryApp\Util\View\ExecutionDate::byExecution($lastExecution) : $translator->noValue() ?>
            <? if(null !== $lastExecution && null !== $lastExecution->getWorker()): ?>
                <?= $translator->by() ?> <?= \DoEveryApp\Util\View\Worker::get($lastExecution->getWorker()) ?>
            <? endif ?>
        </fieldset>

    </div>
    <? if(0 !== sizeof($executions)): ?>
        <div class="column">
            <?= $this->fetchTemplate('partial/durations.php', ['durations' => $durations]) ?>
        </div>
    <? endif ?>
</div>

<hr>

<div class="row">
    <? if(null !== $task->getNote()): ?>
        <div class="column">
            <?= \DoEveryApp\Util\View\TaskNote::byTask($task) ?>
        </div>
    <? endif ?>
    <? if(0 !== sizeof($task->getCheckListItems())): ?>
        <div class="column">
            <fieldset>
                <legend>
                    <?= $translator->taskList() ?>
                </legend>
                <table>
                    <thead>
                    <tr>
                        <th>
                            <?= $translator->step() ?>
                        </th>
                        <th>
                            <?= $translator->notice() ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($task->getCheckListItems() as $checkListItem): ?>
                        <tr>
                            <td>
                                <?= \DoEveryApp\Util\View\Escaper::escape($checkListItem->getName()) ?>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\CheckListItemNote::byTaskCheckListItem($checkListItem) ?>
                            </td>
                        </tr>
                    <? endforeach ?>
                    </tbody>
                </table>
            </fieldset>


        </div>
    <? endif ?>
</div>




<? if(0 !== sizeof($executions)): ?>
    <hr />
    <fieldset>
        <legend>
            <?= $translator->executions() ?>
        </legend>

        <table>
            <thead>
                <tr>
                    <th>
                        <?= $translator->date() ?>
                    </th>
                    <th>
                        <?= $translator->worker() ?>
                    </th>
                    <th>
                        <?= $translator->effort() ?>
                    </th>
                    <? if(0 !== sizeof($task->getCheckListItems())): ?>
                        <th>
                            <?= $translator->steps() ?>
                        </th>
                    <? endif ?>
                    <th>
                        <?= $translator->notice() ?>
                    </th>
                    <th class="pullRight">
                        <?= $translator->actions() ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <? foreach($task->getExecutions() as $execution): ?>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\ExecutionDate::byExecution($execution) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get($execution->getWorker()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Duration::byExecution($execution) ?>
                        </td>
                        <? if(0 !== sizeof($task->getCheckListItems())): ?>
                            <td>

                                <? foreach($execution->getCheckListItems() as $checkListItem): ?>

                                    <div class="row">
                                        <div class="column">
                                            <?= \DoEveryApp\Util\View\CheckListItem::byExecutionCheckListItem($checkListItem) ?>
                                        </div>
                                        <div class="column">
                                            <?= \DoEveryApp\Util\View\ExecutionNote::byValue($checkListItem->getNote()) ?>
                                        </div>
                                    </div>
                                <? endforeach ?>
                            </td>
                        <? endif ?>

                        <td>
                            <?= \DoEveryApp\Util\View\ExecutionNote::byExecution($execution) ?>
                        </td>
                        <td class="pullRight">
                            <div class="buttonRow">
                                <a class="primaryButton" href="<?= \DoEveryApp\Action\Execution\EditAction::getRoute($execution->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::edit() ?>
                                    <?= $translator->edit() ?>
                                </a>
                                <a class="dangerButton confirm" href="<?= \DoEveryApp\Action\Execution\DeleteAction::getRoute($execution->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::trash() ?>
                                    <?= $translator->delete() ?>
                                </a>
                            </div>
                        </td>
                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    </fieldset>
<? endif ?>
