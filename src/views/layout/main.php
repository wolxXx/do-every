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
 * @var string $pageTitle
 * @var string $content
 */
?>
<!DOCTYPE HTML>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/app.css?t=<?= filemtime(filename: 'public/app.css') ?>" media="screen" rel="stylesheet" type="text/css"/>
    <script src="/app.js?t=<?= filemtime(filename: 'public/app.js') ?>"></script>
    <script>
        Translations['are you sure?'] = '<?= $translator->areYouSure() ?>';
    </script>
    <script src="/cookie.js?t=<?= filemtime(filename: 'public/cookie.js') ?>"></script>

    <script src="/vendor/fontawesome/js/all.js?t=<?= filemtime(filename: 'public/vendor/fontawesome/js/all.js') ?>"></script>
    <link href="/vendor/fontawesome/css/all.css?t=<?= filemtime(filename: 'public/vendor/fontawesome/css/all.css') ?>" media="screen" rel="stylesheet" type="text/css"/>

    <script src="/vendor/moment/moment.js?t=<?= filemtime(filename: 'public/vendor/moment/moment.js') ?>"></script>
    <script src="/vendor/moment/locales.js?t=<?= filemtime(filename: 'public/vendor/moment/locales.js') ?>"></script>
    <title>
       Do Every
        <?php if(true === isset($pageTitle)): ?>
            - <?= $pageTitle ?>
        <?php endif ?>
    </title>
    <style>
        :root {

        }
    </style>
</head>
<body>
    <div id="app">
        <div id="menu">
            <div style="text-align: right">
                <img src="/bee.png" alt="logo" style="max-width: 100px; max-height: 100px;">
            </div>

            <div id="appTitle">
                <nobr>
                    * DoEvery *
                </nobr>
            </div>
            <?= $this->fetchTemplate(template: 'layout/partial/menu.php') ?>
            <?= $this->fetchTemplate(template: 'layout/partial/language.php') ?>

        </div>
        <div class="" id="content">
            <?= $this->fetchTemplate(template: 'layout/partial/messages.php') ?>
            <?= $content ?>
        </div>
    </div>
</body>
</html>