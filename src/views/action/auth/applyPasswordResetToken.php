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
    Code eingeben
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="token">
            Code
        </label>
        <input id="token" type="text" name="token" value="<?= array_key_exists('token', $data) ? $data['token'] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors('token') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>
</form>
