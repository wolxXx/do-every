<?php

declare(strict_types=1);

/**
 * @var \Slim\Views\PhpRenderer        $this
 * @var \MyDMS\Util\ErrorStore         $errorStore
 * @var string                         $currentRoute
 * @var string                         $currentRoutePattern
 * @var \MyDMS\Model\User|null         $currentUser
 * @var \MyDMS\Model\InternalUser|null $currentInternalUser
 * @var \MyDMS\Util\Translator         $translator
 * @var string                         $title
 * @var \MyDMS\Model\Space[]           $spaces
 */
/**
 * @var string[] $errors
 */
?>

<div class="errors">
    <? foreach($errors as $error): ?>
        <span class="error">
            <?= $error ?>
        </span>
    <? endforeach ?>
</div>