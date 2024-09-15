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
?>
<? if(true === \DoEveryApp\Util\FlashMessenger::hasMessages()): ?>
    <div id="messageContainer">
        <? foreach(\DoEveryApp\Util\FlashMessenger::getDanger() as $message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $message ?>
            </div>
        <? endforeach ?>

        <? foreach(\DoEveryApp\Util\FlashMessenger::getInfo() as $message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $message ?>
            </div>
        <? endforeach ?>

        <? foreach(\DoEveryApp\Util\FlashMessenger::getWarning() as $message): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $message ?>
            </div>
        <? endforeach ?>

        <? foreach(\DoEveryApp\Util\FlashMessenger::getSuccess() as $message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $message ?>
            </div>
        <? endforeach ?>
    </div>
<? endif ?>