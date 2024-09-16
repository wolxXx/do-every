<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 * @var $translator          \DoEveryApp\Util\Translator
 */

/**
 * @var $executions             \DoEveryApp\Entity\Execution[]
 * @var $tasks                  \DoEveryApp\Entity\Task[]
 * @var $tasksWithoutGroup      \DoEveryApp\Entity\Task[]
 * @var $groups                 \DoEveryApp\Entity\Group[]
 * @var $workers                \DoEveryApp\Entity\Worker[]
 * @var $workingOn                \DoEveryApp\Entity\Task[]
 */
$durations = \DoEveryApp\Definition\Durations::FactoryForGlobal();
?>

<h1>
    <?= $translator->executions() ?>
</h1>

<div class="row">
    <div class="column">
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

    </div>
    <div class="column">
        <?= $this->fetchTemplate('partial/durations.php', ['durations' => $durations]) ?>
    </div>
</div>