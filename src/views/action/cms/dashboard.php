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
$tasks     = \DoEveryApp\Util\View\TaskSortByDue::sort($tasks);
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
        }, 2000); // 10 seconds interval
    });
    
</script>

<div id="passwordChange">
    <? if (true === \DoEveryApp\Util\View\Worker::isTimeForPasswortChange($currentUser)): ?>
        <fieldset>
            <legend>
                <?= $translator->attention() ?>
            </legend>
            <? if (null !== $currentUser->getLastPasswordChange()): ?>
                <?= $translator->dashboardLastPasswordChange($currentUser->getLastPasswordChange()) ?><br />
            <? endif ?>
            <?= $translator->dashboardChangePassword() ?>
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\EditAction::getRoute($currentUser->getId()) ?>">
                <?= $translator->go() ?>
            </a>
        </fieldset>
    <? endif ?>
</div>
<div id="twoFactor">
    <? if (null === $currentUser->getTwoFactorSecret()): ?>
        <fieldset>
            <legend>
                <?= $translator->attention() ?>
            </legend>
            <?= $translator->dashboardAddTwoFactor() ?>
            <a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\EnableTwoFactorAction::getRoute($currentUser->getId()) ?>">
                <?= $translator->go() ?>
            </a>
        </fieldset>
    <? endif ?>
</div>
<div id="workingOn">
    <? if (0 !== sizeof($workingOn)): ?>
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
                <? foreach ($workingOn as $workingOnTask): ?>
                    <tr>
                        <td>
                            <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($workingOnTask->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Escaper::escape($workingOnTask->getName()) ?>
                                <? if (null !== $workingOnTask->getGroup()): ?>
                                    (<?= \DoEveryApp\Util\View\Escaper::escape($workingOnTask->getGroup()->getName()) ?>)
                                <? endif ?>
                            </a>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get($workingOnTask->getWorkingOn()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get($workingOnTask->getAssignee()) ?>
                        </td>
                    </tr>
                <? endforeach ?>
                </tbody>
            </table>
        </fieldset>
    <? endif ?>
</div>
<div id="dueTasks">
    <? if (0 !== sizeof($dueTasks)): ?>
        <fieldset>
            <legend>
                <?= $translator->tasksWithDue() ?>
            </legend>
            <div style="margin-bottom: 50px;" class="grid">
                <? foreach ($dueTasks as $task): ?>
                    <div class="column card">
                        <nobr>
                            <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Due::getByTask($task) ?>: <br />
                                <? if (null !== $task->getGroup()): ?>
                                    <?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>:
                                <? endif ?>
                                <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
                                <? foreach ($workingOn as $workingOnTask): ?>
                                    <? if ($workingOnTask->getId() === $task->getId()): ?>
                                        <br />
                                        (<?= $translator->isCurrentlyWorkingOn(\DoEveryApp\Util\View\Worker::get($workingOnTask->getWorkingOn())) ?>)
                                    <? endif ?>
                                <? endforeach ?>
                            </a>
                        </nobr>
                    </div>
                <? endforeach ?>
            </div>
        </fieldset>
    <? endif ?>
</div>
<div id="tasks">
    <? if (0 !== sizeof($tasks)): ?>
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
                <? foreach($tasks as $task): ?>
                    <?
                    $lastExecution = $task::getRepository()->getLastExecution($task)?->getDate();
                    ?>
                    <tr>
                        <td>
                            <? if(null === $task->getGroup()): ?>
                                -
                            <? else: ?>
                                <?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>
                            <? endif ?>
                        </td>
                        <td>
                            <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
                            </a>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get($task->getAssignee()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Worker::get($task->getWorkingOn()) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime($lastExecution) ?>
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\Due::getByTask($task) ?><br />
                            (<?= $task->isNotify()? $translator->willBeNotified() : $translator->willNotBeNotified() ?>)
                        </td>
                        <td>
                            <?= \DoEveryApp\Util\View\IntervalHelper::get($task) ?>
                            <? if(null !== $task->getIntervalType()): ?>
                                (<?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByTask($task) ?>)
                            <? endif ?>
                        </td>
                        <td class="pullRight">
                            <nobr class="buttonRow">
                                <a class="primaryButton" title="<?= $translator->show() ?>" href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::show() ?>
                                </a>
                                <a class="primaryButton" title="<?= $translator->addExecution() ?>" href="<?= \DoEveryApp\Action\Execution\AddAction::getRoute($task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::add() ?>
                                </a>
                                <a class="warningButton" title="<?= $translator->edit() ?>" href="<?= \DoEveryApp\Action\Task\EditAction::getRoute($task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::edit() ?>
                                </a>
                                <a class="dangerButton confirm" title="<?= $translator->delete() ?>" href="<?= \DoEveryApp\Action\Task\DeleteAction::getRoute($task->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Icon::trash() ?>
                                </a>
                            </nobr>
                        </td>
                    </tr>
                <? endforeach ?>
                </tbody>
            </table>
        </fieldset>
    <? endif ?>
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
                    <? foreach($executions as $execution): ?>
                        <tr>
                            <td>
                                <?= \DoEveryApp\Util\View\ExecutionDate::byExecution($execution) ?>
                            </td>
                            <td>
                                <? if(null === $execution->getTask()->getGroup()): ?>
                                    -
                                <? endif?>
                                <? if(null !== $execution->getTask()->getGroup()): ?>
                                    <?= \DoEveryApp\Util\View\Escaper::escape($execution->getTask()->getGroup()->getName()) ?>
                                <? endif?>
                            </td>
                            <td>
                                <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($execution->getTask()->getId()) ?>">
                                    <?= \DoEveryApp\Util\View\Escaper::escape($execution->getTask()->getName()) ?>
                                </a>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\Duration::byExecution($execution) ?>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\Worker::get($execution->getWorker()) ?>
                            </td>
                            <td>
                                <?= \DoEveryApp\Util\View\ExecutionNote::byExecution($execution) ?>
                            </td>
                        </tr>
                    <? endforeach ?>
                    </tbody>
                </table>
            </fieldset>
        </div>
        <div class="column">
            <?= $this->fetchTemplate('partial/durations.php', ['durations' => $durations]) ?>
        </div>
    </div>
</div>