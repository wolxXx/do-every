<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 */
?>
<!DOCTYPE HTML>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/app.css?t=<?= filemtime('public/app.css') ?>" media="screen" rel="stylesheet" type="text/css"/>
    <script src="/app.js?t=<?= filemtime('public/app.js') ?>"></script>

    <script src="/vendor/fontawesome/js/all.js?t=<?= filemtime('public/vendor/fontawesome/js/all.js') ?>"></script>
    <link href="/vendor/fontawesome/css/all.css?t=<?= filemtime('public/vendor/fontawesome/css/all.css') ?>" media="screen" rel="stylesheet" type="text/css"/>
    <title>
       Do Every
        <? if(true === isset($pageTitle)): ?>
            - <?= $pageTitle ?>
        <? endif ?>
    </title>
</head>
<body>
    <div id="app">
        <div id="menu">
            <div id="appTitle">
                DoEvery*
            </div>
            <?= $this->fetchTemplate('layout/partial/menu.php') ?>
        </div>
        <div class="" id="content">
            <?= $this->fetchTemplate('layout/partial/messages.php') ?>
            <?= $content ?>
        </div>
    </div>
</body>
</html>