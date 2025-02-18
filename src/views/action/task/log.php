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
 * @var \DoEveryApp\Entity\Task[]      $tasks
 * @var \DoEveryApp\Entity\Task[]      $tasksWithoutGroup
 * @var \DoEveryApp\Entity\Group[]     $groups
 * @var \DoEveryApp\Entity\Worker[]    $workers
 * @var \DoEveryApp\Entity\Task[]      $workingOn
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

    </div>
    <div class="column">
        <?= $this->fetchTemplate(template: 'partial/durations.php', data: ['durations' => $durations]) ?>
    </div>
</div>