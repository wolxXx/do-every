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
    <?= $translator->login() ?>
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="email">
            <?= $translator->eMail() ?>
        </label>
        <input id="email" type="email" name="<?= \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL ?>" value="<?= array_key_exists(\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL, $data) ? $data[\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL] : '' ?>"/>
        <div class="errors">
            <?php foreach ($errorStore->getErrors(\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL) as $error): ?>
                <?= $error ?><br/>
            <?php endforeach ?>
        </div>
    </div>
    <div>
        <label for="password">
            <?= $translator->password() ?>
        </label>
        <input id="password" type="password" name="<?= \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD ?>" value="<?= array_key_exists(\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD, $data) ? $data[\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD] : '' ?>"/>
        <div class="errors">
            <?foreach ($errorStore->getErrors(\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD) as $error): ?>
                <?= $error ?><br/>
            <?php endforeach ?>
        </div>
    </div>
    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->go() ?>">
    </div>
</form>