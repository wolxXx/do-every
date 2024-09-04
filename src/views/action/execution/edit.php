<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 */

/**
 * @var $task            \DoEveryApp\Entity\Task
 * @var $data            array
 */

?>


<h1>
    Ausführung bearbeiten
</h1>

<div>
    <form action="" method="post" novalidate>
        <div>
            <label for="worker">
                Worker
            </label>
            <select name="worker" id="worker">
                <option <?= false === array_key_exists('worker', $data) || null === $data['worker'] ? 'selected'  : '' ?>  value="">
                    - niemand -
                </option>
                <? foreach(\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
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

        <div>
            <label for="note">
                Notiz
            </label>
            <textarea name="note" id="note" rows="10000" cols="10000"><?= array_key_exists('note', $data) ? $data['note'] : '' ?></textarea>
        </div>

        <div>
            <input class="primaryButton" type="submit" value="speichern" />
        </div>
    </form>
</div>
