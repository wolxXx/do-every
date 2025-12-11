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
                <label for="theme">
                    <?= $translator->theme() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_THEME ?>" id="theme">
                    <?php foreach(\DoEveryApp\Definition\AppTheme::cases() as $theme): ?>
                        <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_THEME, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_THEME] == $theme->value ? 'selected' : '' ?>  value="<?= $theme->value ?>">
                            <?= $theme->value ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE)]) ?>
            </div>
        </div>
    </div>
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
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE)]) ?>
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
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE)]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="backupDelay">
                    <?= $translator->backupDelay() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_BACKUP_DELAY ?>" id="keepBackups">
                    <?php foreach(range(start: 1, end: 72) as $delay): ?>
                        <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_BACKUP_DELAY, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_BACKUP_DELAY] == ''.$delay ? 'selected' : '' ?>  value="<?= $delay ?>">
                            <?= $delay ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_BACKUP_DELAY)]) ?>
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
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS)]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="passwordChangeInterval">
                    <?= $translator->passwordChangeInterval() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PASSWORD_CHANGE_INTERVAL ?>" id="passwordChangeInterval">
                    <?php foreach(range(start: 0, end: 36) as $interval): ?>
                        <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PASSWORD_CHANGE_INTERVAL, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PASSWORD_CHANGE_INTERVAL] == ''.$interval ? 'selected' : '' ?>  value="<?= $interval ?>">
                            <?= $interval ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PASSWORD_CHANGE_INTERVAL)]) ?>
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
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_USE_TIMER)]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="doIncludeSecurityNoteInMailContent">
                    <?= $translator->mailContentIncludeSecurityNote() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_SECURITY ?>" id="doIncludeSecurityNoteInMailContent">
                    <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_SECURITY, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_SECURITY] == '1' ? 'selected' : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?=  false === array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_SECURITY, array: $data) || $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_SECURITY] == '0' ? 'selected' : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_SECURITY)]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="doIncludeStepsInMailContent">
                    <?= $translator->mailContentIncludeSteps() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_STEPS ?>" id="doIncludeStepsInMailContent">
                    <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_STEPS, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_STEPS] == '1' ? 'selected' : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?=  false === array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_STEPS, array: $data) || $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_STEPS] == '0' ? 'selected' : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_CONTENT_STEPS)]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="markdownEnabled">
                    <?= $translator->markdownTransformationEnabled() ?>
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_MARKDOWN_ENABLED ?>" id="markdownEnabled">
                    <option <?= array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_MARKDOWN_ENABLED, array: $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_MARKDOWN_ENABLED] == '1' ? 'selected' : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?=  false === array_key_exists(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_MARKDOWN_ENABLED, array: $data) || $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_MARKDOWN_ENABLED] == '0' ? 'selected' : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_MARKDOWN_ENABLED)]) ?>
            </div>
        </div>
    </div>

    <div class="form-footer">
        <button type="submit" class="primaryButton">
            <?= \DoEveryApp\Util\View\Icon::save() ?>
        </button>
    </div>
</form>