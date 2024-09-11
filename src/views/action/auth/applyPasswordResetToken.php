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
    Code eingeben
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="token">
            Code
        </label>
        <input id="token" type="text" name="<?= \DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::FORM_FIELD_TOKEN ?>" value="<?= array_key_exists(\DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::FORM_FIELD_TOKEN, $data) ? $data[\DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::FORM_FIELD_TOKEN] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors(\DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::FORM_FIELD_TOKEN) as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>
</form>
