<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 */

/**
 * @var $image string
 * @var $code1 string
 * @var $code2 string
 * @var $code3 string
 * @var $worker \DoEveryApp\Entity\Worker
 */

?>

<h1>
    2FA für Worker <?= \DoEveryApp\Util\View\Escaper::escape($worker->getName()) ?> einrichten
</h1>
<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <?= $image ?>
        </div>
        <div class="column">
            <fieldset>
                <legend>
                    Hinweis
                </legend>
                Scanne den QR-Code links mit deiner Authenticator-App (bspw. Google Authenticator). <br />
                Speichere dir an einem sicheren Ort die drei Codes, mit denen du ins System kommst,
                sollte deine Authenticator-App mal nicht zur Hand sein.<br /><br />
                Drücke im Anschluss den Speichern-Knopf, um den Vorgang abzuschließen und den Datensatz
                digital zu speichern.
            </fieldset>

            <table class="keyValue">
                <thead>
                    <tr>
                        <th>
                            Code
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\Escaper::escape($code1) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\Escaper::escape($code2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?= \DoEveryApp\Util\View\Escaper::escape($code3) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-footer">
        <input class="primaryButton" type="submit" value="speichern" />
    </div>
</form>