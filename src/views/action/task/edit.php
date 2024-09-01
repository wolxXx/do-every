<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $data array
 * @var $task \DoEveryApp\Entity\Task
 */
$groups = \DoEveryApp\Entity\Group::getRepository()->findIndexed();

?>
<h1>
    Aufgabe "<?= \DoEveryApp\Util\View\Escaper::escape($task->getName()) ?>" bearbeiten
</h1>
<form action="" method="post" novalidate>
    <? if(0 !== sizeof($groups)): ?>
        <div>
            <label for="group">
                Gruppe
            </label>
            <select name="group" id="group">
                <option <?= false === array_key_exists('group', $data) || null === $data['group'] ? 'selected'  : '' ?>  value="">
                    - ohne -
                </option>
                <? foreach($groups as $group): ?>
                    <option <?= array_key_exists('group', $data) && $data['group'] == $group->getId() ? 'selected'  : '' ?> value="<?= $group->getId() ?>">
                        <?= \DoEveryApp\Util\View\Escaper::escape($group->getName()) ?>
                    </option>
                <? endforeach ?>
            </select>
            <div class="errors">
                <? foreach ($errorStore->getErrors('group') as $error): ?>
                    <?= $error ?><br/>
                <? endforeach ?>
            </div>
        </div>
    <? endif ?>

    <div>
        <label for="name">
            Name
        </label>
        <input id="name" type="text" name="name" value="<?= array_key_exists('name', $data) ? $data['name'] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors('name') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>


    <div>
        <label for="assignee">
            zugewiesen an
        </label>
        <select name="assignee" id="assignee">
            <option <?= false === array_key_exists('assignee', $data) || null === $data['assignee'] ? 'selected'  : '' ?>  value="">
                - niemand -
            </option>
            <? foreach(\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
                <option <?= array_key_exists('assignee', $data) && $data['assignee'] == $worker->getId() ? 'selected'  : '' ?> value="<?= $worker->getId() ?>">
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
        <label for="intervalType">
            Intervaltyp
        </label>
        <select name="intervalType" id="intervalType">
            <option <?= false === array_key_exists('intervalType', $data) || null === $data['intervalType'] ? 'selected'  : '' ?>  value="">
                - ohne -
            </option>
            <option <?= array_key_exists('intervalType', $data) && $data['intervalType'] == \DoEveryApp\Definition\IntervalType::MINUTE->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\IntervalType::MINUTE->value ?>">
                <?= \DoEveryApp\Util\View\IntervalHelper::map(\DoEveryApp\Definition\IntervalType::MINUTE) ?>
            </option>
            <option <?= array_key_exists('intervalType', $data) && $data['intervalType'] == \DoEveryApp\Definition\IntervalType::HOUR->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\IntervalType::HOUR->value ?>">
                <?= \DoEveryApp\Util\View\IntervalHelper::map(\DoEveryApp\Definition\IntervalType::HOUR) ?>
            </option>
            <option <?= array_key_exists('intervalType', $data) && $data['intervalType'] == \DoEveryApp\Definition\IntervalType::DAY->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\IntervalType::DAY->value ?>">
                <?= \DoEveryApp\Util\View\IntervalHelper::map(\DoEveryApp\Definition\IntervalType::DAY) ?>
            </option>
            <option <?= array_key_exists('intervalType', $data) && $data['intervalType'] == \DoEveryApp\Definition\IntervalType::MONTH->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\IntervalType::MONTH->value ?>">
                <?= \DoEveryApp\Util\View\IntervalHelper::map(\DoEveryApp\Definition\IntervalType::MONTH) ?>
            </option>
            <option <?= array_key_exists('intervalType', $data) && $data['intervalType'] == \DoEveryApp\Definition\IntervalType::YEAR->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\IntervalType::YEAR->value ?>">
                <?= \DoEveryApp\Util\View\IntervalHelper::map(\DoEveryApp\Definition\IntervalType::YEAR) ?>
            </option>
        </select>
        <div class="errors">
            <? foreach ($errorStore->getErrors('intervalType') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>


    <div>
        <label for="intervalValue">
            Intervalwert
        </label>
        <input id="intervalValue" type="number" name="intervalValue" value="<?= array_key_exists('intervalValue', $data) ? $data['intervalValue'] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors('intervalValue') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>


    <div>
        <label for="priority">
            Priorität
        </label>
        <select name="priority" id="priority">
            <option <?= array_key_exists('priority', $data) && $data['priority'] == \DoEveryApp\Definition\Priority::LOW->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\Priority::LOW->value ?>">
                <?= \DoEveryApp\Util\View\PriorityMap::mapName(\DoEveryApp\Definition\Priority::LOW) ?>
            </option>
            <option <?= false === array_key_exists('priority', $data) || $data['priority'] == \DoEveryApp\Definition\Priority::NORMAL->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\Priority::NORMAL->value ?>">
                <?= \DoEveryApp\Util\View\PriorityMap::mapName(\DoEveryApp\Definition\Priority::NORMAL) ?>
            </option>
            <option <?= array_key_exists('priority', $data) && $data['priority'] == \DoEveryApp\Definition\Priority::HIGH->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\Priority::HIGH->value ?>">
                <?= \DoEveryApp\Util\View\PriorityMap::mapName(\DoEveryApp\Definition\Priority::HIGH) ?>
            </option>
            <option <?= array_key_exists('priority', $data) && $data['priority'] == \DoEveryApp\Definition\Priority::URGENT->value ? 'selected'  : '' ?>  value="<?= \DoEveryApp\Definition\Priority::URGENT->value ?>">
                <?= \DoEveryApp\Util\View\PriorityMap::mapName(\DoEveryApp\Definition\Priority::URGENT) ?>
            </option>
        </select>
        <div class="errors">
            <? foreach ($errorStore->getErrors('priority') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>


    <div>
        <label for="enableNotifications">
            benachrichtigen?
        </label>
        <select name="enableNotifications" id="enableNotifications">
            <option <?= array_key_exists('enableNotifications', $data) && $data['enableNotifications'] == '1' ? 'selected'  : '' ?>  value="1">
                ja
            </option>
            <option <?=  false === array_key_exists('enableNotifications', $data) || $data['enableNotifications'] == '0' ? 'selected'  : '' ?>  value="0">
                nein
            </option>
        </select>
        <div class="errors">
            <? foreach ($errorStore->getErrors('priority') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>

</form>
