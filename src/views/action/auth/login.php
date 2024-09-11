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
    Login
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="email">
            E-Mail
        </label>
        <input id="email" type="email" name="<?= \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL ?>" value="<?= array_key_exists(\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL, $data) ? $data[\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors(\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL) as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>
    <div>
        <label for="password">
            Passwort
        </label>
        <input id="password" type="password" name="<?= \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD ?>" value="<?= array_key_exists(\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD, $data) ? $data[\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD] : '' ?>"/>
        <div class="errors">
            <?foreach ($errorStore->getErrors(\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD) as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>
    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>

</form>
