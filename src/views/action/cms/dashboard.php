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
    document.addEventListener('DOMContentLoaded', function () {
        setInterval(function () {
            fetch('/', {
                method: 'GET',
            })
                .then(response => {
                    return response.text();
                })
                .then(data => {
                    const parser = new DOMParser()
                    const doc = parser.parseFromString(data, "text/html")
                    let replaces = [
                        'passwordChange',
                        'twoFactor',
                        'workingOn',
                        'dueTasks',
                        'tasks',
                        'executions',
                    ];
                    replaces.forEach(id => {
                        let replace = ''
                        if (doc.getElementById(id)) {
                            replace = doc.getElementById(id).innerHTML
                        }
                        document.getElementById(id).innerHTML = replace
                    })
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        }, 10000);
    });

</script>

<div id="passwordChange">
    <?php if (true === \DoEveryApp\Util\View\Worker::isTimeForPasswortChange(worker: $currentUser)): ?>
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
<div id="twoFactor">
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
<div id="workingOn">
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
<div id="dueTasks">
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
<div id="tasks">
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
                                (<?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByTask(task: $task) ?>)
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
                                <a class="dangerButton confirm" title="<?= $translator->delete() ?>" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute(id: $task->getId()) ?>">
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

<div id="executions">
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