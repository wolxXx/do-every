<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
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
    Ausführungen
</h1>

<div class="row">
    <div class="column">
        <table>
            <thead>
            <tr>
                <th>
                    Datum
                </th>
                <th>
                    Gruppe
                </th>
                <th>
                    Aufgabe
                </th>
                <th>
                    Aufwand
                </th>
                <th>
                    Worker
                </th>
                <th>
                    Notiz
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