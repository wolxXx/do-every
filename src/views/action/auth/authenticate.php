<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
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
        <input class="primaryButton" type="submit" value="los">
    </div>
</form>
