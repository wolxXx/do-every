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
        <input id="email" type="email" name="email" value="<?= array_key_exists('email', $data) ? $data['email'] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors('email') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>
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
    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>

</form>
