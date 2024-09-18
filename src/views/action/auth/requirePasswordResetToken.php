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

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->go() ?>">
    </div>
</form>
