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
    <? if (null === $execution): ?>
        Ausführung hinzufügen
    <? endif ?>
    <? if (null !== $execution): ?>
        Ausführung bearbeiten
    <? endif ?>
</h1>
<div>
    <a href="<?= \DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()) ?>">
        Aufgabe: <?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>
    </a>
    <? if (null !== $task->getGroup()): ?>
        |  Gruppe:
        <a href="<?= \DoEveryApp\Action\Group\ShowAction::getRoute($task->getGroup()->getId()) ?>">
            <?= \DoEveryApp\Util\View\Escaper::escape($task->getGroup()->getName()) ?>
        </a>
    <? endif ?>
    <hr />
</div>

<? if (null !== $task->getNote()): ?>
    <div>
        <?= \DoEveryApp\Util\View\TaskNote::byTask($task) ?>
    </div>
<? endif ?>

<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <div>
                <label for="worker">
                    <?= $translator->worker() ?>
                </label>
                <select name="worker" id="worker">
                    <option <?= false === array_key_exists('worker', $data) || null === $data['worker'] ? 'selected'  : '' ?>  value="">
                        - niemand -
                    </option>
                    <? foreach (\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
                        <option <?= array_key_exists('worker', $data) && $data['worker'] == $worker->getId() ? 'selected'  : '' ?> value="<?= $worker->getId() ?>">
                            <?= \DoEveryApp\Util\View\Worker::get($worker) ?>
                        </option>
                    <? endforeach ?>
                </select>
                <div class="errors">
                    <? foreach ($errorStore->getErrors('assignee') as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>

            <div>
                <label for="date" class="required">
                    Datum
                </label>
                <input type="datetime-local" id="date" name="date" value="<?= array_key_exists('date', $data) ? $data['date'] : '' ?>"/>
            </div>

            <div>
                <label for="duration">
                    Dauer
                </label>
                <input type="number" id="duration" name="duration" value="<?= array_key_exists('duration', $data) ? $data['duration'] : '' ?>"/>
                Minuten
            </div>

            <? if (0 !== sizeof($data['checkListItems'])): ?>
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
                        <? foreach ($data['checkListItems'] as $index =>  $checkListItem): ?>
                            <tr>
                                <td>
                                    <?= \DoEveryApp\Util\View\Escaper::escape($checkListItem['name']) ?>
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][checked]" value="0">
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][reference]" value="<?= $checkListItem['reference'] ?>">
                                    <input type="hidden" readonly checked name="checkListItems[<?= $index ?>][id]" value="<?= $checkListItem['id'] ?>">
                                </td>
                                <td>
                                    <input type="checkbox" <?= '1' === $checkListItem['checked']? 'checked': '' ?> name="checkListItems[<?= $index ?>][checked]" value="1">
                                </td>
                                <td>
                                    <?= \DoEveryApp\Util\View\CheckListItemNote::byValue($checkListItem['referenceNote']) ?>
                                </td>
                                <td>
                                    <textarea rows="1000" cols="1000" name="checkListItems[<?= $index ?>][note]"><?= $checkListItem['note'] ?></textarea>
                                </td>
                            </tr>
                        <? endforeach ?>
                    </tbody>
                </table>
                <??>
            <? endif ?>
        </div>
        <div class="column">

            <div>
                <label for="note">
                    Notiz
                </label>
                <textarea name="note" id="note" rows="10000" cols="10000"><?= array_key_exists('note', $data) ? $data['note'] : '' ?></textarea>
            </div>
        </div>
    </div>

    <div>
        <input class="primaryButton" type="submit" value="hinzufügen" />
    </div>
</form>