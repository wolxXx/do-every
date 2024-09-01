<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $data array
 */


?>
<h1>
    Passwort vergessen!
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

    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>
</form>
