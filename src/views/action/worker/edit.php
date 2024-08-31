<?php

/**
 * @var $this         \Slim\Views\PhpRenderer
 * @var $errorStore   \DoEveryApp\Util\ErrorStore
 * @var $currentRoute string
 */

/**
 * @var $data array
 * @var $worker \DoEveryApp\Entity\Worker
 */

?>
<h1>
    Worker "<?= \DoEveryApp\Util\View\Escaper::escape($worker->getName()) ?>" bearbeiten
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="name">
            Name
        </label>
        <input id="name" type="text" name="name" value="<?= array_key_exists('name', $data) ? $data['name'] : '' ?>"/>
        <div class="errors">
            <? foreach ($errorStore->getErrors('name') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

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
            <? foreach ($errorStore->getErrors('password') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>

    <div>
        <label for="is_admin">
            ist Admin?
        </label>
        <select name="is_admin" id="is_admin">
            <option <?= array_key_exists('is_admin', $data) && $data['is_admin'] == '1' ? 'selected'  : '' ?>  value="1">
                ja
            </option>
            <option <?=  false === array_key_exists('is_admin', $data) || $data['is_admin'] == '0' ? 'selected'  : '' ?>  value="0">
                nein
            </option>
        </select>
        <div class="errors">
            <? foreach ($errorStore->getErrors('is_admin') as $error): ?>
                <?= $error ?><br/>
            <? endforeach ?>
        </div>
    </div>


    <div class="app-card-footer">
        <input class="primaryButton" type="submit" value="los">
    </div>
</form>
