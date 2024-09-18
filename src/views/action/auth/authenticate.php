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
?>
<h1>
    Zwei-Faktor-Validierung
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="token">
            Code
        </label>
        <input id="token" type="text" name="<?= \DoEveryApp\Action\Auth\AuthenticateAction::FORM_FIELD_CODE ?>" />
    </div>
    <div>
        <label for="recoveryCode">
            oder Recovery-Code
        </label>
        <input id="recoveryCode" type="text" name="<?= \DoEveryApp\Action\Auth\AuthenticateAction::FORM_FIELD_RECOVERY_CODE ?>" />
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->go() ?>">
    </div>
</form>
