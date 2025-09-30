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
    <?= $translator->login() ?>
</h1>
<form action="" method="post" novalidate>
    <div>
        <label for="email">
            <?= $translator->eMail() ?>
        </label>
        <input id="email" type="email" name="<?= \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL ?>" value="<?= array_key_exists(key: \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL, array: $data) ? $data[\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL] : '' ?>"/>
        <div class="errors">
            <?php foreach ($errorStore->getErrors(key: \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_EMAIL) as $error): ?>
                <?= $error ?><br/>
            <?php endforeach ?>
        </div>
    </div>
    <div>
        <label for="password">
            <?= $translator->password() ?>
        </label>
        <input id="password" type="password" name="<?= \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD ?>" value="<?= array_key_exists(key: \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD, array: $data) ? $data[\DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD] : '' ?>"/>
        <div class="errors">
            <?php foreach ($errorStore->getErrors(key: \DoEveryApp\Action\Auth\LoginAction::FORM_FIELD_PASSWORD) as $error): ?>
                <?= $error ?><br/>
            <?php endforeach ?>
        </div>
    </div>
    <div id="status">

    </div>
    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->go() ?>">
        <button class="primaryButton" id="passkeyLogin">
            <?= $translator->loginWithPasskey() ?>
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('passkeyLogin').addEventListener('click', async (event) => {
            event.stopPropagation();
            event.preventDefault();

            const publicKey = {
                challenge: new Uint8Array([
                    <?php foreach(str_split(bin2hex(random_bytes(10))) as $char): ?>
                        <?= ord($char) ?>,
                    <?php endforeach ?>
                ]),
                rpId: "<?= false === strstr($_SERVER['HTTP_HOST'], 'localhost')? $_SERVER['HTTP_HOST'] : 'localhost' ?>",
            }
            try {
                const credential = await navigator.credentials.get({ publicKey: publicKey })

                const response = await fetch('<?= \DoEveryApp\Action\Auth\PasskeyLoginAction::getRoute() ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        <?= \DoEveryApp\Action\Auth\PasskeyLoginAction::FORM_FIELD_PUBLIC_KEY ?>: credential.id,
                        <?= \DoEveryApp\Action\Auth\PasskeyLoginAction::FORM_FIELD_LOGIN ?>: document.getElementById('email').value,
                    })
                });

                window.location = '<?= \DoEveryApp\Action\Cms\IndexAction::getRoute() ?>';
            } catch (err) {
                console.error("Error creating credential:", err);
                alert('<?= $translator->passkeyLoginError() ?>');
            }
            return false;
        })
    });
</script>