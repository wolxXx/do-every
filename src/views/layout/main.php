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
    <title>
       Do Every
        <? if(true === isset($pageTitle)): ?>
            - <?= $pageTitle ?>
        <? endif ?>
    </title>
</head>
<body>
<?= $this->fetchTemplate('layout/partial/menu.php') ?>

<div class="" id="content" style="margin-top: 70px; min-height: 80%;">
    <?= $this->fetchTemplate('layout/partial/messages.php') ?>
    <?= $content ?>
</div>
</body>
</html>