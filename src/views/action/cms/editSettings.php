<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 * @var $translator          \DoEveryApp\Util\Translator
 */
/**
 * @var $data array
 */
?>

<h1>
    Einstellungen bearbeiten
</h1>

<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <div>
                <label for="fillTimeLine">
                    Zeitlinie auffüllen?
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE ?>" id="fillTimeLine">
                    <option <?= array_key_exists(\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE, $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE] == '1' ? 'selected'  : '' ?>  value="1">
                        ja
                    </option>
                    <option <?=  false === array_key_exists(\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE, $data) || $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE] == '0' ? 'selected'  : '' ?>  value="0">
                        nein
                    </option>
                </select>
                <div class="errors">
                    <? foreach ($errorStore->getErrors(\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_FILL_TIME_LINE) as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="precisionDue">
                    Fälligkeitpräzision
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE ?>" id="precisionDue">
                    <? foreach(range(0, 5) as $precision): ?>
                        <option <?= array_key_exists(\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE, $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE] == ''.$precision ? 'selected'  : '' ?>  value="<?= $precision ?>">
                            <?= $precision ?>
                        </option>
                    <? endforeach ?>
                </select>
                <div class="errors">
                    <? foreach ($errorStore->getErrors(\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_PRECISION_DUE) as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="keepBackups">
                    Backups aufheben (Tage)
                </label>
                <select name="<?= \DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS ?>" id="keepBackups">
                    <? foreach(range(0, 90) as $precision): ?>
                        <option <?= array_key_exists(\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS, $data) && $data[\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS] == ''.$precision ? 'selected'  : '' ?>  value="<?= $precision ?>">
                            <?= $precision ?>
                        </option>
                    <? endforeach ?>
                </select>
                <div class="errors">
                    <? foreach ($errorStore->getErrors(\DoEveryApp\Action\Cms\EditSettingsAction::FORM_FIELD_KEEP_BACKUPS) as $error): ?>
                        <?= $error ?><br/>
                    <? endforeach ?>
                </div>
            </div>
        </div>
    </div>




    <div class="form-footer">
        <input class="primaryButton" type="submit" value="speichern">
    </div>
</form>