<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 * @var $translator          \DoEveryApp\Util\Translator
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
    <?= sprintf($translator->enableTwoFactorForWorker(),\DoEveryApp\Util\View\Worker::get($worker) ) ?>
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
                <?= \DoEveryApp\Util\View\Escaper::escape($code1) ?><br />
                <?= \DoEveryApp\Util\View\Escaper::escape($code2) ?><br />
                <?= \DoEveryApp\Util\View\Escaper::escape($code3) ?><br />
            </fieldset>
        </div>
    </div>
    <div class="form-footer">
        <input class="primaryButton" type="submit" value="<?= $translator->save() ?>" />
    </div>
</form>