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
 * @var $data   \DoEveryApp\Entity\Execution[]
 * @var $worker \DoEveryApp\Entity\Worker
 */
$durations    = \DoEveryApp\Definition\Durations::FactoryByWorker($worker);
?>
<h1>
    <?= sprintf($translator->logFor(), \DoEveryApp\Util\View\Worker::get($worker)) ?>
</h1>

<? if(0 === sizeof($data)): ?>
    <?= sprintf($translator->workerDidNothing(), \DoEveryApp\Util\View\Worker::get($worker)) ?>
<? endif ?>
<? if(0 !== sizeof($data)): ?>
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
                        <?= $translator->note() ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <? foreach($data as $execution): ?>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\ExecutionDate::byExecution($execution) ?>
                        </td>
                        <td>
                            <? if(null === $execution->getTask()->getGroup()): ?>
                                <?= $translator->noValue() ?>
                            <? endif ?>
                            <? if(null !== $execution->getTask()->getGroup()): ?>
                                <?= \DoEveryApp\Util\View\Escaper::escape($execution->getTask()->getGroup()->getName()) ?>
                            <? endif ?>
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
<? endif ?>