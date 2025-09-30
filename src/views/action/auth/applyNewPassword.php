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
    <?= $translator->pageTitleSetNewPassword() ?>
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="password">
            <?= $translator->password() ?>
        </label>
        <input id="password" type="password" name="<?= \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD ?>" value="<?= $data[\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD] ?? '' ?>"/>
        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD)]) ?>
    </div>

    <div>
        <label for="confirm_password">
            <?= $translator->confirmPassword() ?>
        </label>
        <input id="confirm_password" type="password" name="<?= \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD_CONFIRM ?>" value="<?= $data[\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD_CONFIRM] ?? '' ?>"/>
        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::FORM_FIELD_PASSWORD_CONFIRM)]) ?>
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->go() ?>">
    </div>
</form>
