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
?>

<h1>
    <?= $translator->editSettings() ?>
</h1>

<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <div>
                <label for="fillTimeLine">
                    <?= $translator->fillTimeLineQuestion() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE ?>" id="fillTimeLine">
                    <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE] == '1' ? 'selected' : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?=  false === array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE, array: $data) || $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE] == '0' ? 'selected' : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <div class="errors">
                    <?php foreach ($errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE) as $error): ?>
                        <?= $error ?><br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="precisionDue">
                    <?= $translator->duePrecision() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE ?>" id="precisionDue">
                    <?php foreach(range(start: 0, end: 5) as $precision): ?>
                        <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE] == ''.$precision ? 'selected' : '' ?>  value="<?= $precision ?>">
                            <?= $precision ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <div class="errors">
                    <?php foreach ($errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE) as $error): ?>
                        <?= $error ?><br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="keepBackups">
                    <?= $translator->keepBackupDays() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS ?>" id="keepBackups">
                    <?php foreach(range(start: 0, end: 90) as $precision): ?>
                        <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS] == ''.$precision ? 'selected' : '' ?>  value="<?= $precision ?>">
                            <?= $precision ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <div class="errors">
                    <?php foreach ($errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS) as $error): ?>
                        <?= $error ?><br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="doUseTimer">
                    <?= $translator->useTimer() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_USE_TIMER ?>" id="doUseTimer">
                    <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_USE_TIMER, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_USE_TIMER] == '1' ? 'selected' : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?=  false === array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_USE_TIMER, array: $data) || $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_USE_TIMER] == '0' ? 'selected' : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <div class="errors">
                    <?php foreach ($errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_USE_TIMER) as $error): ?>
                        <?= $error ?><br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-footer">
        <button type="submit" class="primaryButton">
            <?= \DoEveryApp\Util\View\Icon::save() ?>
        </button>
    </div>
</form>