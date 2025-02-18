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
 * @var \DoEveryApp\Entity\Execution[] $data
 * @var \DoEveryApp\Entity\Worker      $worker
 */
$durations = \DoEveryApp\Definition\Durations::FactoryByWorker(worker: $worker);
?>
<h1>
    <?= $translator->logFor(who: \DoEveryApp\Util\View\Worker::get(worker: $worker)) ?>
</h1>

<?php if(0 === count(value: $data)): ?>
    <?= $translator->workerDidNothing(who: \DoEveryApp\Util\View\Worker::get(worker: $worker)) ?>
<?php endif ?>
<?php if(0 !== count(value: $data)): ?>
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
                <?php foreach($data as $execution): ?>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\ExecutionDate::byExecution(execution: $execution) ?>
                        </td>
                        <td>
                            <?php if(null === $execution->getTask()->getGroup()): ?>
                                <?= $translator->noValue() ?>
                            <?php endif ?>
                            <?php if(null !== $execution->getTask()->getGroup()): ?>
                                <?= \DoEveryApp\Util\View\Escaper::escape(value: $execution->getTask()->getGroup()->getName()) ?>
                            <?php endif ?>
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
<?php endif ?>