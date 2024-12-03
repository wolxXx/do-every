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
 * @var array $data
 */
$groups = \DoEveryApp\Entity\Group::getRepository()->findIndexed();
?>

<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <div class="row">
                <? if(0 !== sizeof($groups)): ?>
                    <div class="column">
                        <div>
                            <label for="group">
                                <?= $translator->group() ?>
                            </label>
                            <select name="group" id="group">
                                <option <?= false === array_key_exists('group', $data) || null === $data['group'] ? 'selected'  : '' ?>  value="">
                                    - <?= $translator->without() ?> -
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
                    </div>
                <? endif ?>
                <div class="column">
                    <div>
                        <label for="name" class="required">
                            <?= $translator->name() ?>
                        </label>
                        <input id="name" type="text" name="name" value="<?= array_key_exists('name', $data) ? $data['name'] : '' ?>"/>
                        <div class="errors">
                            <? foreach ($errorStore->getErrors('name') as $error): ?>
                                <?= $error ?><br/>
                            <? endforeach ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="column">
                    <div>
                        <label for="assignee">
                            <?= $translator->assignedTo() ?>
                        </label>
                        <select name="assignee" id="assignee">
                            <option <?= false === array_key_exists('assignee', $data) || null === $data['assignee'] ? 'selected'  : '' ?>  value="">
                                - <?= $translator->nobody() ?> -
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
                </div>
                <div class="column">
                    <div>
                        <label for="enableNotifications">
                            <?= $translator->doNotifyDueTasksQuestion() ?>
                        </label>
                        <select name="enableNotifications" id="enableNotifications">
                            <option <?= array_key_exists('enableNotifications', $data) && $data['enableNotifications'] == '1' ? 'selected'  : '' ?>  value="1">
                                <?= $translator->yes() ?>
                            </option>
                            <option <?=  false === array_key_exists('enableNotifications', $data) || $data['enableNotifications'] == '0' ? 'selected'  : '' ?>  value="0">
                                <?= $translator->no() ?>
                            </option>
                        </select>
                        <div class="errors">
                            <? foreach ($errorStore->getErrors('priority') as $error): ?>
                                <?= $error ?><br/>
                            <? endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="column">

                    <div>
                        <label for="priority">
                            <?= $translator->priority() ?>
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
                </div>
            </div>

            <div class="row">
                <div class="column">
                    <div>
                        <label for="intervalType">
                            <?= $translator->intervalType() ?>
                        </label>
                        <select name="intervalType" id="intervalType">
                            <option <?= false === array_key_exists('intervalType', $data) || null === $data['intervalType'] ? 'selected'  : '' ?>  value="">
                                - <?= $translator->without() ?> -
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
                </div>
                <div class="column">
                    <div>
                        <label for="intervalValue">
                            <?= $translator->intervalValue() ?>
                        </label>
                        <input id="intervalValue" type="number" name="intervalValue" value="<?= array_key_exists('intervalValue', $data) ? $data['intervalValue'] : '' ?>"/>
                        <div class="errors">
                            <? foreach ($errorStore->getErrors('intervalValue') as $error): ?>
                                <?= $error ?><br/>
                            <? endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="elapsingCronType">
                            <?= $translator->intervalMode() ?>
                        </label>
                        <select name="elapsingCronType" id="elapsingCronType">
                            <option <?= false === array_key_exists('elapsingCronType', $data) || $data['elapsingCronType'] == '1' ? 'selected'  : '' ?>  value="1">
                                <?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByBoolean(true) ?>
                            </option>
                            <option <?= array_key_exists('elapsingCronType', $data) && $data['elapsingCronType'] == '0' ? 'selected'  : '' ?>  value="0">
                                <?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByBoolean(false) ?>
                            </option>
                        </select>
                        <div class="errors">
                            <? foreach ($errorStore->getErrors('elapsingCronType') as $error): ?>
                                <?= $error ?><br/>
                            <? endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="note">
                    <?= $translator->notice() ?>
                </label>
                <textarea name="note" id="note" rows="10000" cols="10000"><?= array_key_exists('note', $data) ? $data['note'] : '' ?></textarea>
                <div class="errors">
                    <? foreach ($errorStore->getErrors('note') as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3>
            <?= $translator->steps() ?>
        </h3>
        <div>
            <?= $translator->stepsQuestion() ?>
        </div>
        <i class="rowAdder primaryButton">
            <?= \DoEveryApp\Util\View\Icon::add() ?>
            <?= $translator->add() ?>
        </i>
        <div class="rows" ondrop="dropHandler(event)" ondragover="dragoverHandler(event)">
            <? foreach ($data['checkListItem']??[] as $index => $item): ?>
                <div class="rowSimple" draggable="true">
                    <div class="column">
                        <span class="dangerButton rowRemover">
                            <i class="fa fa-minus"></i>
                        </span>
                    </div>
                    <div class="column">
                        <? $id = \Ramsey\Uuid\Uuid::uuid4()->toString() ?>
                        <label for="<?= $id ?>">
                            <?= $translator->step() ?>
                        </label>
                        <input type="hidden" readonly name="checkListItem[<?= $index ?>][id]" value="<?= $item['id'] ?? '' ?>" />
                        <input type="hidden" readonly name="checkListItem[<?= $index ?>][position]" value="<?= $item['position'] ?? '' ?>" />
                        <input id="<?= $id ?>" type="text" name="checkListItem[<?= $index ?>][name]" value="<?= $item['name'] ?>" />
                    </div>
                    <div class="column">
                        <? $id = \Ramsey\Uuid\Uuid::uuid4()->toString() ?>
                        <label for="<?= $id ?>">
                            <?= $translator->notice() ?>
                        </label>
                        <textarea id="<?= $id ?>" rows="1000" cols="1000" name="checkListItem[<?= $index ?>][note]"><?= $item['note'] ?? '' ?></textarea>
                    </div>
                </div>
            <? endforeach ?>
        </div>
        <template>
            <div class="rowSimple" draggable="true">
                <div class="column">
                    <span class="dangerButton rowRemover">
                        <i class="fa fa-minus"></i>
                    </span>
                </div>
                <div class="column">
                    <label for="newRow__INDEX__Name">
                        <?= $translator->step() ?>
                    </label>
                    <input type="hidden" readonly name="checkListItem[__INDEX__][id]" />
                    <input type="hidden" readonly name="checkListItem[__INDEX__][position]" />
                    <input id="newRow__INDEX__Name" type="text" name="checkListItem[__INDEX__][name]" />
                </div>
                <div class="column">
                    <label for="newRow__INDEX__Note">
                        <?= $translator->notice() ?>
                    </label>
                    <textarea id="newRow__INDEX__Note" rows="1000" cols="1000" name="checkListItem[__INDEX__][note]"></textarea>
                </div>
            </div>
        </template>
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->save() ?>">
    </div>

</form>