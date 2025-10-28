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
 * @var \DoEveryApp\Entity\Task\Timer[] $timers
 */
?>

<h1><?= $translator->timer() ?></h1>
<table class="app-table">
    <thead>
        <tr>
            <th>
                <?= $translator->running() ?>
            </th>
            <th>
                <?= $translator->task() ?>
            </th>
            <th>
                <?= $translator->worker() ?>
            </th>
            <th>
                <?= $translator->sections() ?>
            </th>
            <th>
                <?= $translator->actions() ?>
                <a href="<?= \DoEveryApp\Action\Task\Timer\DeleteAllAction::getRoute() ?>" class="dangerButton confirm" data-message="<?= $translator->reallyWantToDeleteAllTimers() ?>">
                    <?= \DoEveryApp\Util\View\Icon::trash() ?>
                </a>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($timers as $timer): ?>
            <tr>
                <td>
                    <?= \DoEveryApp\Util\View\Boolean::get(false === $timer->isStopped()) ?>
                </td>
                <td>
                    <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($timer->getTask()->getId()) ?>">
                        <?= $timer->getTask()->getName() ?>
                        <?php if(null !== $timer->getTask()->getGroup()): ?>
                            (<?= $timer->getTask()->getGroup()->getName() ?>)
                        <?php endif ?>
                    </a>
                </td>
                <td>
                    <?= $timer->getWorker()->getName() ?>
                </td>
                <td>
                    <?php foreach ($timer->getSections() as $section): ?>
                        <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(dateTime: $section->getStart()) ?> -
                        <?= \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateMediumTime(dateTime: $section->getEnd()) ?>
                        <br />
                    <?php endforeach  ?>
                </td>
                <td>
                    <a href="<?= \DoEveryApp\Action\Task\Timer\DeleteAction::getRoute(id: $timer->getId()) ?>" class="dangerButton confirm" data-message="<?= $translator->reallyWantToDeleteTimer() ?>">
                        <?= \DoEveryApp\Util\View\Icon::trash() ?>
                    </a>
                </td>
            </tr>
    <?php endforeach ?>
    </tbody>
</table>