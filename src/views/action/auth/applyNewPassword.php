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
        <input id="password" type="password" name="password" value="<?= array_key_exists('password', $data) ? $data['password'] : '' ?>"/>
        <div class="errors">
            <?foreach ($errorStore->getErrors('password') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div>
        <label for="confirm_password">
            Passwort bestätigen
        </label>
        <input id="confirm_password" type="password" name="confirm_password" value="<?= array_key_exists('confirm_password', $data) ? $data['confirm_password'] : '' ?>"/>
        <div class="errors">
            <?foreach ($errorStore->getErrors('confirm_password') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>

</form>
