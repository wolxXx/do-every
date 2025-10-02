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
 * @var string[] $errors
 */
?>

<div class="errors">
    <?php foreach ($errors as $error): ?>
        <span class="error">
            <?= $error ?>
        </span>
    <?php endforeach ?>
</div>