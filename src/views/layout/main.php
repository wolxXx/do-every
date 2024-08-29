<?php
/**
 * @var $this \Slim\Views\PhpRenderer
 * @var $errorStore \DoEveryApp\Util\ErrorStore
 * @var $content string
 * @var $currentRoute string
 */
?>
<!DOCTYPE HTML>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/app.css?t=<?= filemtime('public/app.css') ?>" media="screen" rel="stylesheet" type="text/css"/>
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