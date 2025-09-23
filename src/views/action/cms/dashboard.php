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
 * @var \DoEveryApp\Entity\Execution[] $executions
 * @var \DoEveryApp\Entity\Task[]      $dueTasks
 * @var \DoEveryApp\Entity\Task[]      $tasks
 * @var \DoEveryApp\Entity\Task[]      $disabledTasks
 * @var \DoEveryApp\Entity\Worker[]    $workers
 * @var \DoEveryApp\Entity\Task[]      $workingOn
 */
$durations = \DoEveryApp\Definition\Durations::FactoryForGlobal();
$tasks     = \DoEveryApp\Util\View\TaskSortByDue::sort(tasks: $tasks);
?>

<h1>
    <?= $translator->dashboard() ?>
</h1>

<script>
    const local_timeout = 3000;
</script>

<div id="passwordChange" class="replaceMe">
    <?php if (true === \DoEveryApp\Util\View\Worker::isTimeForPasswordChange(worker: $currentUser)): ?>
        <fieldset>
            <legend>
                <?= $translator->attention() ?>
            </legend>
            <?php if (null !== $currentUser->getLastPasswordChange()): ?>
                <?= $translator->dashboardLastPasswordChange(dateTime: $currentUser->getLastPasswordChange()) ?><br />
            <?php endif ?>
            <?= $translator->dashboardChangePassword() ?>
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\EditAction::getRoute(id: $currentUser->getId()) ?>">
                <?= $translator->go() ?>
            </a>
        </fieldset>
    <?php endif ?>
</div>
<div id="twoFactor" class="replaceMe">
    <?php if (null === $currentUser->getTwoFactorSecret()): ?>
        <fieldset>
            <legend>
                <?= $translator->attention() ?>
            </legend>
            <?= $translator->dashboardAddTwoFactor() ?>
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\EnableTwoFactorAction::getRoute(id: $currentUser->getId()) ?>">
                <?= $translator->go() ?>
            </a>
        </fieldset>
    <?php endif ?>
</div>
<div id="workingOn" class="replaceMe">
    <?php if (0 !== count(value: $workingOn)): ?>
        <fieldset>
            <legend>
                <?= $translator->currentWorks() ?>
            </legend>

            <table style="margin-bottom: 50px;">
                <thead>
                <tr>
                    <th>
                        <?= $translator->task() ?>
                    </th>
                    <th>
                        <?= $translator->currentlyWorkingOn() ?>
                    </th>
                    <th>
                        <?= $translator->assignedTo() ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($workingOn as $workingOnTask): ?>
                    <tr>
                        <td>
                            <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $workingOnTask->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Escaper::escape(value: $workingOnTask->getName()) ?>
                                <?php if (null !== $workingOnTask->getGroup()): ?>
                                    (<?= \DoEveryApp\Util\View\Escaper::escape(value: $workingOnTask->getGroup()->getName()) ?>)
                                <?php endif ?>
                            </a>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get(worker: $workingOnTask->getWorkingOn()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get(worker: $workingOnTask->getAssignee()) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </fieldset>
    <?php endif ?>
</div>
<div id="dueTasks" class="replaceMe">
    <?php if (0 !== count(value: $dueTasks)): ?>
        <fieldset>
            <legend>
                <?= $translator->tasksWithDue() ?>
            </legend>
            <div style="margin-bottom: 50px;" class="grid">
                <?php foreach ($dueTasks as $task): ?>
                    <div class="column card">
                        <nobr>
                            <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Due::getByTask(task: $task) ?>: <br />
                                <?php if (null !== $task->getGroup()): ?>
                                    <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) ?>:
                                <?php endif ?>
                                <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) ?>
                                <?php foreach ($workingOn as $workingOnTask): ?>
                                    <?php if ($workingOnTask->getId() === $task->getId()): ?>
                                        <br />
                                        (<?= $translator->isCurrentlyWorkingOn(who: \DoEveryApp\Util\View\Worker::get(worker: $workingOnTask->getWorkingOn())) ?>)
                                    <?php endif ?>
                                <?php endforeach ?>
                            </a>
                        </nobr>
                    </div>
                <?php endforeach ?>
            </div>
        </fieldset>
    <?php endif ?>
</div>
<div id="tasks" class="replaceMe">
    <?php if (0 !== count(value: $tasks)): ?>
        <fieldset>
            <legend>
                <?= $translator->tasks() ?>
            </legend>

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
                        <?= $translator->lastExecution() ?>
                    </th>
                    <th>
                        <?= $translator->due() ?>
                    </th>
                    <th>
                        <?= $translator->interval() ?>
                    </th>
                    <th>
                        <?= $translator->actions() ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($tasks as $task): ?>
                    <?php
                    $lastExecution = $task::getRepository()->getLastExecution(task: $task)?->getDate();
                    ?>
                    <tr>
                        <td>
                            <?php if(null === $task->getGroup()): ?>
                                -
                            <?php else: ?>
                                <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) ?>
                            <?php endif ?>
                        </td>
                        <td>
                            <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) ?>
                            </a>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get(worker: $task->getAssignee()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get(worker: $task->getWorkingOn()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(dateTime: $lastExecution) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Due::getByTask(task: $task) ?><br />
                            (<?= $task->isNotify() ? $translator->willBeNotified() : $translator->willNotBeNotified() ?>)
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\IntervalHelper::get(task: $task) ?>
                            <?php if(null !== $task->getIntervalType()): ?>
                                (<?= \DoEveryApp\Util\View\IntervalHelper::getTypeByTask(task: $task) ?>)
                            <?php endif ?>
                        </td>
                        <td class="pullRight">
                            <nobr class="buttonRow">
                                <a class="primaryButton" title="<?= $translator->show() ?>" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::show() ?>
                                </a>
                                <a class="primaryButton" title="<?= $translator->addExecution() ?>" href="<?= \DoEveryApp\Action\Execution\AddAction::getRoute(id: $task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::add() ?>
                                </a>
                                <a class="warningButton" title="<?= $translator->edit() ?>" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute(id: $task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::edit() ?>
                                </a>
                                <a class="dangerButton confirm" data-message="<?= \DoEveryApp\Util\View\Escaper::escape(value: $translator->reallyWantToDeleteTask(name: $task->getName())) ?>" title="<?= $translator->delete() ?>" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute(id: $task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::trash() ?>
                                </a>
                            </nobr>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </fieldset>
    <?php endif ?>
</div>

<hr>

<div id="executions" class="replaceMe">
    <div class="row">
        <div class="column">
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
                            <?= $translator->group() ?>
                        </th>
                        <th>
                            <?= $translator->task() ?>
                        </th>
                        <th>
                            <?= $translator->effort() ?>
                        </th>
                        <th>
                            <?= $translator->worker() ?>
                        </th>
                        <th>
                            <?= $translator->note() ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($executions as $execution): ?>
                        <tr>
                            <td>
                                <?= \DoEveryApp\Util\View\ExecutionDate::byExecution(execution: $execution) ?>
                            </td>
                            <td>
                                <?php if(null === $execution->getTask()->getGroup()): ?>
                                    -
                                <?php endif?>
                                <?php if(null !== $execution->getTask()->getGroup()): ?>
                                    <?= \DoEveryApp\Util\View\Escaper::escape(value: $execution->getTask()->getGroup()->getName()) ?>
                                <?php endif?>
                            </td>
                            <td>
                                <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $execution->getTask()->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Escaper::escape(value: $execution->getTask()->getName()) ?>
                                </a>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\Duration::byExecution(execution: $execution) ?>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\Worker::get(worker: $execution->getWorker()) ?>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\ExecutionNote::byExecution(execution: $execution) ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </fieldset>
        </div>
        <div class="column">
            <?= $this->fetchTemplate(template: 'partial/durations.php', data: ['durations' => $durations]) ?>
        </div>
    </div>
</div>

<div id="disabledTasks" class="replaceMe">
    <?php if (0 !== count(value: $disabledTasks)): ?>
        <fieldset>
            <legend>
                <?= $translator->disabledTasks() ?>
            </legend>
            <table>
                <thead>
                    <tr>
                        <th>
                            <?= $translator->group() ?>
                        </th>
                        <th>
                            <?= $translator->task() ?>
                        </th>
                        <th>
                            <?= $translator->actions() ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($disabledTasks as $task): ?>
                        <tr>
                            <td>
                                <?= $task->getGroup()?->getName() ?: '-' ?>
                            </td>
                            <td>
                                <?= $task->getName() ?>
                            </td>
                            <td>
                                <nobr class="buttonRow">
                                    <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>" class="primaryButton">
                                        <?= \DoEveryApp\Util\View\Icon::show() ?>
                                    </a>
                                </nobr>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </fieldset>
    <?php endif ?>
</div>