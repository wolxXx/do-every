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
    Code eingeben
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="token">
            Code
        </label>
        <input id="token" type="text" name="<?= \DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::FORM_FIELD_TOKEN ?>" value="<?= $data[\DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::FORM_FIELD_TOKEN] ?? '' ?>"/>
        <?= $this->fetchTemplate(template: 'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::FORM_FIELD_TOKEN)]) ?>
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->go() ?>">
    </div>
</form>
