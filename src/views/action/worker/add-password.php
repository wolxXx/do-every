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
 * @var \DoEveryApp\Entity\Worker $worker
 */
?>
<h1>
    <?= $translator->addPassword() ?>
</h1>


<form action="" method="post" novalidate autocomplete="off">
    <div class="row">
        <div class="column">
            <div>
                <label for="<?= \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD ?>">
                    <?= $translator->password() ?>
                </label>
                <input id="<?= \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD ?>" type="password" name="<?= \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD ?>" value=""/>
                <?= $this->fetchTemplate(template:'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD)]) ?>
            </div>
        </div>
        <div class="column">
            <div>
                <label for="<?= \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD_REPEAT ?>">
                    <?= $translator->passwordRepeat() ?>
                </label>
                <input id="<?= \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD_REPEAT ?>" type="password" name="<?= \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD_REPEAT ?>" value=""/>
                <?= $this->fetchTemplate(template:'partial/formErrors.php', data: ['errors' => $errorStore->getErrors(key: \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD_REPEAT)]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <button id="proposePassword" class="primaryButton">
                <?= $translator->proposePassword() ?>
            </button>
            <div id="proposedPassword"></div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('proposePassword').addEventListener('click', function(event) {
                        event.preventDefault();
                        event.stopPropagation();


                        let password = Chelsea.getBadAss(20);

                        document.getElementById('proposedPassword').innerHTML = password;

                        document.getElementById('<?= \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD ?>').value = password;
                        document.getElementById('<?= \DoEveryApp\Action\Worker\AddPasswordAction::FORM_FIEL_PASSWORD_REPEAT ?>').value = password;

                        return false;
                    })
                });
            </script>
        </div>
    </div>

    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->save() ?>">
    </div>
</form>

