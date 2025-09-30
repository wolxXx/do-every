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
 * @var \DoEveryApp\Entity\Worker $worker
 * @var array $pubKeyCredParams
 * @var string $challenge
 * @var \Webauthn\PublicKeyCredentialRpEntity $rpEntity
 * @var \Webauthn\PublicKeyCredentialUserEntity $userEntity
 */
?>

<script>
    (async () => {
        // Create a new credential request in JSON format
        const publicKey = {
            challenge: new Uint8Array([
                <?php foreach(str_split(bin2hex(base64_decode($challenge))) as $char): ?>
                    <?= ord($char) ?>,
                <?php endforeach ?>
            ]).buffer,
            rp: {
                id: "<?= $rpEntity->id ?>",
                name: "<?= $rpEntity->name?>"
            },
            user: {
                id: new Uint8Array([
                    <?php  foreach(str_split($userEntity->id) as $char): ?>
                        <?= ord($char) ?>,
                    <?php endforeach ?>
                ]).buffer,
                name: "<?= $userEntity->name ?>",
                displayName: "<?= $userEntity->displayName ?>"
            },
            pubKeyCredParams: [
                {
                    type: "public-key",
                    alg: -7  // ES256 algorithm
                }
            ],
            authenticatorSelection: {
                authenticatorAttachment: "cross-platform",
                residentKey: "required"
            },
        };

        try {
            const credential = await navigator.credentials.create({publicKey: publicKey});
            const response = await fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: credential.id,
                    rawId: btoa(String.fromCharCode(...new Uint8Array(credential.rawId))),
                    type: credential.type,
                    response: {
                        attestationObject: btoa(String.fromCharCode(...new Uint8Array(credential.response.attestationObject))),
                        clientDataJSON: btoa(String.fromCharCode(...new Uint8Array(credential.response.clientDataJSON)))
                    }
                })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }

            const jsonResponse = await response.json();
            window.location = '<?= \DoEveryApp\Action\Worker\IndexAction::getRoute() ?>';
        } catch (err) {
            console.error("Error creating credential:", err);
            alert('das hat nicht geklappt.. bitte seite neu laden...');
        }
    })();
</script>

<a class="primaryButton" href="<?= \DoEveryApp\Action\Worker\IndexAction::getRoute() ?>">
    <?= $translator->workers() ?>
</a>