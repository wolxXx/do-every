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

<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <div>
                <label for="<?= \DoEveryApp\Action\Worker\EditAction::FORM_FIELD_NAME ?>">
                    <?= $translator->name() ?>
                </label>
                <input id="<?= \DoEveryApp\Action\Worker\EditAction::FORM_FIELD_NAME ?>" type="text" name="<?= \DoEveryApp\Action\Worker\EditAction::FORM_FIELD_NAME ?>" value="<?= $data[\DoEveryApp\Action\Worker\EditAction::FORM_FIELD_NAME] ?? '' ?>"/>
                <?= $this->fetchTemplate(template:'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Worker\EditAction::FORM_FIELD_NAME)]) ?>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="email">
                    <?= $translator->eMail() ?>
                </label>
                <input id="email" type="email" name="email" value="<?= array_key_exists(key: 'email', array: $data) ? $data['email'] : '' ?>"/>
                <div class="errors">
                    <?php foreach ($errorStore->getErrors(key: 'email') as $error): ?>
                        <?= $error ?><br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="is_admin">
                    <?= $translator->isAdminQuestion() ?>
                </label>
                <select name="is_admin" id="is_admin">
                    <option <?= array_key_exists(key: 'is_admin', array: $data) && $data['is_admin'] == '1' ? 'selected' : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?=  false === array_key_exists(key: 'is_admin', array: $data) || $data['is_admin'] == '0' ? 'selected' : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <div class="errors">
                    <?php foreach ($errorStore->getErrors(key: 'is_admin') as $error): ?>
                        <?= $error ?><br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="do_notify_logins">
                    <?= $translator->doNotifyLoginsQuestion() ?>
                </label>
                <select name="do_notify_logins" id="do_notify_logins">
                    <option <?= array_key_exists(key: 'do_notify_logins', array: $data) && $data['do_notify_logins'] == '1' ? 'selected' : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?= false === array_key_exists(key: 'do_notify_logins', array: $data) || $data['do_notify_logins'] == '0' ? 'selected' : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <div class="errors">
                    <?php foreach ($errorStore->getErrors(key: 'do_notify_logins') as $error): ?>
                        <?= $error ?><br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div>
                <label for="do_notify">
                    <?= $translator->doNotifyDueTasksQuestion() ?>
                </label>
                <select name="do_notify" id="do_notify">
                    <option <?= array_key_exists(key: 'do_notify', array: $data) && $data['do_notify'] == '1' ? 'selected' : '' ?>  value="1">
                        <?= $translator->yes() ?>
                    </option>
                    <option <?= false === array_key_exists(key: 'do_notify', array: $data) || $data['do_notify'] == '0' ? 'selected' : '' ?>  value="0">
                        <?= $translator->no() ?>
                    </option>
                </select>
                <div class="errors">
                    <?php foreach ($errorStore->getErrors(key: 'do_notify') as $error): ?>
                        <?= $error ?><br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->save() ?>">
    </div>
</form>

