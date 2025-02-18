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
 * @var \DoEveryApp\Entity\Execution | null $execution
 * @var \DoEveryApp\Entity\Task             $task
 * @var array                               $data
 */
?>

<h1>
    <?php if (null === $execution): ?>
        Ausführung hinzufügen
    <?php endif ?>
    <?php if (null !== $execution): ?>
        Ausführung bearbeiten
    <?php endif ?>
</h1>
<div>
    <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()) ?>">
        Aufgabe: <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getName()) ?>
    </a>
    <?php if (null !== $task->getGroup()): ?>
        |  Gruppe:
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute(id: $task->getGroup()->getId()) ?>">
            <?= \DoEveryApp\Util\View\Escaper::escape(value: $task->getGroup()->getName()) ?>
        </a>
    <?php endif ?>
    <hr />
</div>

<?php if (null !== $task->getNote()): ?>
    <div>
        <?= \DoEveryApp\Util\View\TaskNote::byTask(task: $task) ?>
    </div>
<?php endif ?>

<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                    <div>
                        <label for="worker">
                            <?= $translator->worker() ?>
                        </label>
                        <select name="worker" id="worker">
                            <option <?= false === array_key_exists(key: 'worker', array: $data) || null === $data['worker'] ? 'selected' : '' ?>  value="">
                                - niemand -
                            </option>
                            <?php foreach (\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
                                <option <?= array_key_exists(key: 'worker', array: $data) && $data['worker'] == $worker->getId() ? 'selected' : '' ?> value="<?= $worker->getId() ?>">
                                    <?= \DoEveryApp\Util\View\Worker::get(worker: $worker) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <div class="errors">
                            <?php foreach ($errorStore->getErrors(key: 'assignee') as $error): ?>
                                <?= $error ?><br/>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="date" class="required">
                            Datum
                        </label>
                        <input type="datetime-local" id="date" name="date" value="<?= array_key_exists(key: 'date', array: $data) ? $data['date'] : '' ?>"/>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="duration">
                            Dauer
                        </label>
                        <input type="number" id="duration" name="duration" value="<?= array_key_exists(key: 'duration', array: $data) ? $data['duration'] : '' ?>"/>
                        Minuten
                    </div>
                </div>
            </div>




            <?php if (0 !== count(value: $data['checkListItems'])): ?>
                <hr>
                <table>
                    <thead>
                        <tr>
                            <th>
                                Schritt
                            </th>
                            <th>
                                erledigt?
                            </th>
                            <th>
                                Hinweis
                            </th>
                            <th>
                                Notiz
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['checkListItems'] as $index =>  $checkListItem): ?>
                            <tr>
                                <td>
                                    <?= \DoEveryApp\Util\View\Escaper::escape(value: $checkListItem['name']) ?>
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][checked]" value="0">
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][reference]" value="<?= $checkListItem['reference'] ?>">
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][id]" value="<?= $checkListItem['id'] ?>">
                                </td>
                                <td>
                                    <input type="checkbox" <?= '1' === $checkListItem['checked'] ? 'checked' : '' ?> name="checkListItems[<?= $index ?>][checked]" value="1">
                                </td>
                                <td>
                                    <?= \DoEveryApp\Util\View\CheckListItemNote::byValue(note: $checkListItem['referenceNote']) ?>
                                </td>
                                <td>
                                    <textarea rows="1000" cols="1000" name="checkListItems[<?= $index ?>][note]"><?= $checkListItem['note'] ?></textarea>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <??>
            <?php endif ?>
        </div>
        <div class="column">

            <div>
                <label for="note">
                    Notiz
                </label>
                <textarea name="note" id="note" rows="10000" cols="10000"><?= array_key_exists(key: 'note', array: $data) ? $data['note'] : '' ?></textarea>
            </div>
        </div>
    </div>

    <div>
        <?php if (null === $execution): ?>
            <input class="primaryButton" type="submit" value="<?= $translator->add() ?>" />
        <?php endif ?>
        <?php if (null !== $execution): ?>
            <input class="primaryButton" type="submit" value="<?= $translator->save() ?>" />
        <?php endif ?>

    </div>
</form>