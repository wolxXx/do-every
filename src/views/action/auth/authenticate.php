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
    <?= $translator->twoFactorValidation() ?>
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="<?= \DoEveryApp\Action\Auth\AuthenticateAction::FORM_FIELD_CODE ?>">
            <?= $translator->code() ?>
        </label>
        <input id="<?= \DoEveryApp\Action\Auth\AuthenticateAction::FORM_FIELD_CODE ?>" type="text" name="<?= \DoEveryApp\Action\Auth\AuthenticateAction::FORM_FIELD_CODE ?>" />
        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD)]) ?>
    </div>
    <div>
        <label for="recoveryCode">
            <?= $translator->orUseRecoveryCode() ?>
        </label>
        <input id="recoveryCode" type="text" name="<?= \DoEveryApp\Action\Auth\AuthenticateAction::FORM_FIELD_RECOVERY_CODE ?>" />
        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD)]) ?>
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->go() ?>">
    </div>
</form>
