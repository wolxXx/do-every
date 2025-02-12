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
?>
<?php if(true === \DoEveryApp\Util\FlashMessenger::hasMessages()): ?>
    <div id="messageContainer">
        <?php foreach(\DoEveryApp\Util\FlashMessenger::getDanger() as $message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $message ?>
            </div>
        <?php endforeach ?>

        <?php foreach(\DoEveryApp\Util\FlashMessenger::getInfo() as $message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $message ?>
            </div>
        <?php endforeach ?>

        <?php foreach(\DoEveryApp\Util\FlashMessenger::getWarning() as $message): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $message ?>
            </div>
        <?php endforeach ?>

        <?php foreach(\DoEveryApp\Util\FlashMessenger::getSuccess() as $message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $message ?>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>