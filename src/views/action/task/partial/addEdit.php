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
            <div class="grid">
                <?php if(0 !== count(value: $groups)): ?>
                    <div class="column">
                        <div>
                            <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_GROUP ?>">
                                <?= $translator->group() ?>
                            </label>
                            <select name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_GROUP ?>" id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_GROUP ?>">
                                <option <?= false === array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_GROUP, array: $data) || null === $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_GROUP] ? 'selected' : '' ?>  value="">
                                    - <?= $translator->without() ?> -
                                </option>
                                <?php foreach($groups as $group): ?>
                                    <option <?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_GROUP, array: $data) && $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_GROUP] == $group->getId() ? 'selected' : '' ?> value="<?= $group->getId() ?>">
                                        <?= \DoEveryApp\Util\View\Escaper::escape(value: $group->getName()) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_GROUP)]) ?>
                        </div>
                    </div>
                <?php endif ?>

                <div class="column">
                    <div>
                        <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NAME ?>" class="required">
                            <?= $translator->name() ?>
                        </label>
                        <input id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NAME ?>" type="text" name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NAME ?>" value="<?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NAME, array: $data) ? $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_NAME] : '' ?>"/>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NAME)]) ?>
                    </div>
                </div>
            </div>

            <div class="grid">
                <div class="column">
                    <div>
                        <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ASSIGNEE ?>">
                            <?= $translator->assignedTo() ?>
                        </label>
                        <select name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ASSIGNEE ?>" id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ASSIGNEE ?>">
                            <option <?= false === array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ASSIGNEE, array: $data) || null === $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_ASSIGNEE] ? 'selected' : '' ?>  value="">
                                - <?= $translator->nobody() ?> -
                            </option>
                            <?php foreach(\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker): ?>
                                <option <?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ASSIGNEE, array: $data) && $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_ASSIGNEE] == $worker->getId() ? 'selected' : '' ?> value="<?= $worker->getId() ?>">
                                    <?= \DoEveryApp\Util\View\Worker::get(worker: $worker) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ASSIGNEE)]) ?>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ENABLE_NOTIFICATIONS ?>">
                            <?= $translator->doNotifyDueTasksQuestion() ?>
                        </label>
                        <select name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ENABLE_NOTIFICATIONS ?>" id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ENABLE_NOTIFICATIONS ?>">
                            <option <?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ENABLE_NOTIFICATIONS, array: $data) && $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_ENABLE_NOTIFICATIONS] == '1' ? 'selected' : '' ?>  value="1">
                                <?= $translator->yes() ?>
                            </option>
                            <option <?= false === array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ENABLE_NOTIFICATIONS, array: $data) || $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_ENABLE_NOTIFICATIONS] == '0' ? 'selected' : '' ?>  value="0">
                                <?= $translator->no() ?>
                            </option>
                        </select>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ENABLE_NOTIFICATIONS)]) ?>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_PRIORITY ?>">
                            <?= $translator->priority() ?>
                        </label>
                        <select name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_PRIORITY ?>" id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_PRIORITY ?>">
                            <?php foreach(\DoEveryApp\Definition\Priority::cases() as $priorityCase): ?>
                                <option <?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_PRIORITY, array: $data) && $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_PRIORITY] == $priorityCase->value ? 'selected' : '' ?>  value="<?= $priorityCase->value ?>">
                                    <?= \DoEveryApp\Util\View\PriorityMap::mapName(priority: $priorityCase) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_PRIORITY)]) ?>
                    </div>
                </div>
            </div>

            <div class="grid">
                <div class="column">
                    <div>
                        <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_TYPE ?>">
                            <?= $translator->intervalType() ?>
                        </label>
                        <select name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_TYPE ?>" id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_TYPE ?>">
                            <option <?= false === array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_TYPE, array: $data) || null === $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_TYPE] ? 'selected' : '' ?>  value="">
                                - <?= $translator->without() ?> -
                            </option>
                            <?php foreach(\DoEveryApp\Definition\IntervalType::cases() as $intervalTypeCase): ?>
                                <option <?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_TYPE, array: $data) && $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_TYPE] == $intervalTypeCase->value ? 'selected' : '' ?>  value="<?= $intervalTypeCase->value ?>">
                                    <?= \DoEveryApp\Util\View\IntervalHelper::map(intervalType: $intervalTypeCase) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_TYPE)]) ?>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_VALUE ?>">
                            <?= $translator->intervalValue() ?>
                        </label>
                        <input id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_VALUE ?>" type="number" name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_VALUE ?>" value="<?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_VALUE, array: $data) ? $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_VALUE] : '' ?>"/>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_INTERVAL_VALUE)]) ?>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ELAPSING_CRON_TYPE ?>">
                            <?= $translator->intervalMode() ?>
                        </label>
                        <select name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ELAPSING_CRON_TYPE ?>" id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ELAPSING_CRON_TYPE ?>">
                            <option <?= false === array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ELAPSING_CRON_TYPE, array: $data) || $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_ELAPSING_CRON_TYPE] == '1' ? 'selected' : '' ?>  value="1">
                                <?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByBoolean(elapsing: true) ?>
                            </option>
                            <option <?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ELAPSING_CRON_TYPE, array: $data) && $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_ELAPSING_CRON_TYPE] == '0' ? 'selected' : '' ?>  value="0">
                                <?= \DoEveryApp\Util\View\IntervalHelper::getElapsingTypeByBoolean(elapsing: false) ?>
                            </option>
                        </select>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_ELAPSING_CRON_TYPE)]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NOTE ?>">
                    <?= $translator->notice() ?>
                </label>
                <textarea name="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NOTE ?>" id="<?= \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NOTE ?>" rows="10000" cols="10000"><?= array_key_exists(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NOTE, array: $data) ? $data[\DoEveryApp\Action\Task\AddAction::FORM_FIELD_NOTE] : '' ?></textarea>
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_NOTE)]) ?>
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
            <?php foreach ($data['checkListItem'] ?? [] as $index => $item): ?>
                <div class="rowSimple" draggable="true">
                    <div class="column">
                        <span class="dangerButton rowRemover">
                            <i class="fa fa-minus"></i>
                        </span>
                    </div>
                    <div class="column">
                        <?php $id = \Ramsey\Uuid\Uuid::uuid4()->toString() ?>
                        <label for="<?= $id ?>">
                            <?= $translator->step() ?>
                        </label>
                        <input type="hidden" readonly name="checkListItem[<?= $index ?>][id]" value="<?= $item['id'] ?? '' ?>" />
                        <input type="hidden" readonly name="checkListItem[<?= $index ?>][position]" value="<?= $item['position'] ?? '' ?>" />
                        <input id="<?= $id ?>" type="text" name="checkListItem[<?= $index ?>][name]" value="<?= $item['name'] ?>" />

                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_CHECK_LIST_ITEM . '_' . $index . '_' . \DoEveryApp\Action\Task\AddAction::FORM_FIELD_CHECK_LIST_ITEM_NAME)]) ?>
                    </div>
                    <div class="column">
                        <?php $id = \Ramsey\Uuid\Uuid::uuid4()->toString() ?>
                        <label for="<?= $id ?>">
                            <?= $translator->notice() ?>
                        </label>
                        <textarea id="<?= $id ?>" rows="1000" cols="1000" name="checkListItem[<?= $index ?>][note]"><?= $item['note'] ?? '' ?></textarea>
                        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Task\AddAction::FORM_FIELD_CHECK_LIST_ITEM . '_' . $index . '_' . \DoEveryApp\Action\Task\AddAction::FORM_FIELD_CHECK_LIST_ITEM_NOTE)]) ?>
                    </div>
                </div>
            <?php endforeach ?>
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