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
 * @var $data array
 */


?>
<h1>
    Neues Passwort setzen
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="password">
            Passwort
        </label>
        <input id="password" type="password" name="<?= \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD ?>" value="<?= array_key_exists(\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD, $data) ? $data[\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD] : '' ?>"/>
        <div class="errors">
            <?foreach ($errorStore->getErrors(\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD) as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div>
        <label for="confirm_password">
            Passwort bestätigen
        </label>
        <input id="confirm_password" type="password" name="<?= \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD_CONFIRM ?>" value="<?= array_key_exists(\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD_CONFIRM, $data) ? $data[\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD_CONFIRM] : '' ?>"/>
        <div class="errors">
            <?foreach ($errorStore->getErrors(\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD_CONFIRM) as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>

</form>
