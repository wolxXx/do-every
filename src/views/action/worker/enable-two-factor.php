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
 * @var string                    $image
 * @var string                    $code1
 * @var string                    $code2
 * @var string                    $code3
 * @var \DoEveryApp\Entity\Worker $worker
 */
?>

<h1>
    <?= $translator->enableTwoFactorForWorker(who: \DoEveryApp\Util\View\Worker::get(worker: $worker)) ?>
</h1>
<form action="" method="post" novalidate>
    <div class="row">
        <div class="column">
            <?= $image ?>
        </div>
        <div class="column">
            <fieldset>
                <legend>
                    <?= $translator->notice() ?>
                </legend>
                <?= $translator->twoFactorNotice() ?>

            </fieldset>
            <fieldset>
                <legend>
                    <?= $translator->codes() ?>
                </legend>
                <?= \DoEveryApp\Util\View\Escaper::escape(value: $code1) ?><br />
                <?= \DoEveryApp\Util\View\Escaper::escape(value: $code2) ?><br />
                <?= \DoEveryApp\Util\View\Escaper::escape(value: $code3) ?><br />
            </fieldset>
        </div>
    </div>
    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->save() ?>" />
    </div>
</form>