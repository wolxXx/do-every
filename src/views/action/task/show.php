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
$lastExecution = $task::getRepository()->getLastExecution(task: $task);
$executions    = $task->getExecutions();
$durations     = \DoEveryApp\Definition\Durations::FactoryByTask(task: $task);
?>

<h1>
    <?= $translator->task() ?>: <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) ?>
    <?php if (null !== $task->getGroup()): ?>
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute(id: $task->getGroup()->getId()) ?>">
            (<?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) ?>)
        </a>
    <?php endif ?>
</h1>

<h2>
    <?= \DoEveryApp\Util\View\Due::getByTask(task: $task) ?>
</h2>

<div class="pageButtons buttonRow">
    <?php if(null === $task->getWorkingOn()): ?>
        <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\MarkWorkingAction::getRoute(id: $task->getId(), workingOn: $currentUser->getId()) ?>">
            <?= \DoEveryApp\Util\View\Icon::hand() ?>
            <?= $translator->iAmWorkingOn() ?>
        </a>
    <?php endif ?>
    <?php if(null !== $task->getWorkingOn()): ?>
        <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\MarkWorkingAction::getRoute(id: $task->getId()) ?>">
            <?= \DoEveryApp\Util\View\Icon::cross() ?>
            <?= $translator->nobodyIsWorkingOn() ?>
        </a>
    <?php endif ?>

    <a class="primaryButton" href="<?= \DoEveryApp\Action\Execution\AddAction::getRoute(id: $task->getId()) ?>">
        <?= \DoEveryApp\Util\View\Icon::add() ?>
        <?= $translator->addExecution() ?>
    </a>
    <a class="primaryButton" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute(id: $task->getId()) ?>">
        <?= \DoEveryApp\Util\View\Icon::edit() ?>
        <?= $translator->edit() ?>
    </a>
    <a class="warningButton confirm" data-message="<?= \DoEveryApp\Util\View\Escaper::escape(value: $translator->reallyWantToResetTask(name: $task->getName()))  ?>" href="<?= \DoEveryApp\Action\Task\ResetAction::getRoute(id: $task->getId()) ?>">
        <?= \DoEveryApp\Util\View\Icon::refresh() ?>
        <?= $translator->reset() ?>
    </a>
    <?php if(true === $task->isActive()): ?>
        <a class="warningButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute(id: $task->getId(), active: false) ?>">
            <?= \DoEveryApp\Util\View\Icon::off() ?>
            <?= $translator->deactivate() ?>
        </a>
    <?php endif ?>
    <?php if(false === $task->isActive()): ?>
        <a class="successButton" href="<?= \DoEveryApp\Action\Task\MarkActiveAction::getRoute(id: $task->getId(), active: true) ?>">
            <?= \DoEveryApp\Util\View\Icon::on() ?>
            <?= $translator->activate() ?>
        </a>
    <?php endif ?>

    <a class="dangerButton confirm" data-message="<?= \DoEveryApp\Util\View\Escaper::escape(value: $translator->reallyWantToDeleteTask(name: $task->getName())) ?>" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute(id: $task->getId()) ?>">
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
            <?= $translator->status() ?>: <?= $task->isActive() ? $translator->active() : $translator->paused() ?> |
            <?= $task->isNotify() ? $translator->willBeNotified() : $translator->willNotBeNotified() ?><br />


            <?= $translator->interval() ?>: <?= \DoEveryApp\Util\View\IntervalHelper::get(task: $task) ?>
            <?php if(null !== $task->getIntervalType()): ?>
                (<?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByTask(task: $task) ?>)
            <?php endif ?>
            |

            <?= $translator->priority() ?>: <?= \DoEveryApp\Util\View\PriorityMap::getByTask(task: $task) ?><br />

            <?= $translator->currentlyWorkingOn() ?>: <?= null === $task->getWorkingOn() ? $translator->nobody() : \DoEveryApp\Util\View\Worker::get(worker: $task->getWorkingOn()) ?> |
            <?= $translator->assignedTo() ?>: <?= null === $task->getAssignee() ? $translator->nobody() : \DoEveryApp\Util\View\Worker::get(worker: $task->getAssignee()) ?><br />
            <?= $translator->lastExecution() ?>: <?= $lastExecution ? \DoEveryApp\Util\View\ExecutionDate::byExecution(execution: $lastExecution) : $translator->noValue() ?>
            <?php if(null !== $lastExecution && null !== $lastExecution->getWorker()): ?>
                <?= $translator->by() ?> <?= \DoEveryApp\Util\View\Worker::get(worker: $lastExecution->getWorker()) ?>
            <?php endif ?>
        </fieldset>

    </div>
    <?php if(0 !== count(value: $executions)): ?>
        <div class="column">
            <?= $this->fetchTemplate(template: 'partial/durations.php', data: ['durations' => $durations]) ?>
        </div>
    <?php endif ?>
</div>

<hr>

<div class="row">
    <?php if(null !== $task->getNote()): ?>
        <div class="column">
            <?= \DoEveryApp\Util\View\TaskNote::byTask(task: $task) ?>
        </div>
    <?php endif ?>
    <?php if(0 !== count(value: $task->getCheckListItems())): ?>
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
                    <?php foreach($task->getCheckListItems() as $checkListItem): ?>
                        <tr>
                            <td>
                                <?= \DoEveryApp\Util\View\Escaper::escape(value: $checkListItem->getName()) ?>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\CheckListItemNote::byTaskCheckListItem(item: $checkListItem) ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </fieldset>


        </div>
    <?php endif ?>
</div>




<?php if(0 !== count(value: $executions)): ?>
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
                    <?php if(0 !== count(value: $task->getCheckListItems())): ?>
                        <th>
                            <?= $translator->steps() ?>
                        </th>
                    <?php endif ?>
                    <th>
                        <?= $translator->notice() ?>
                    </th>
                    <th class="pullRight">
                        <?= $translator->actions() ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($task->getExecutions() as $execution): ?>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\ExecutionDate::byExecution(execution: $execution) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get(worker: $execution->getWorker()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Duration::byExecution(execution: $execution) ?>
                        </td>
                        <?php if(0 !== count(value: $task->getCheckListItems())): ?>
                            <td>

                                <?php foreach($execution->getCheckListItems() as $checkListItem): ?>

                                    <div class="row">
                                        <div class="column">
                                            <?= \DoEveryApp\Util\View\CheckListItem::byExecutionCheckListItem(item: $checkListItem) ?>
                                        </div>
                                        <div class="column">
                                            <?= \DoEveryApp\Util\View\ExecutionNote::byValue(note: $checkListItem->getNote()) ?>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </td>
                        <?php endif ?>

                        <td>
                            <?= \DoEveryApp\Util\View\ExecutionNote::byExecution(execution: $execution) ?>
                        </td>
                        <td class="pullRight">
                            <div class="buttonRow">
                                <a class="primaryButton" href="<?= \DoEveryApp\Action\Execution\EditAction::getRoute(id: $execution->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::edit() ?>
                                    <?= $translator->edit() ?>
                                </a>
                                <a class="dangerButton confirm" data-message="<?= \DoEveryApp\Util\View\Escaper::escape(value: $translator->reallyWantToDeleteExecution()) ?>" href="<?= \DoEveryApp\Action\Execution\DeleteAction::getRoute(id: $execution->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::trash() ?>
                                    <?= $translator->delete() ?>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </fieldset>
<?php endif ?>
