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
$theme = \DoEveryApp\Util\Registry::getInstance()->getTheme()?->value ?: 'default';
?>
<!DOCTYPE HTML>
<html lang="de" data-theme="<?= $theme ?>">
<head>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>-->
    <script src="/anime.umd.js"></script>
    <script>
        const { engine, animate, utils, stagger } = anime;
        engine.defaults.delay = 500;

    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/app.css?t=<?= filemtime(filename: 'public/app.css') ?>" media="screen" rel="stylesheet" type="text/css"/>
    <script src="/app.js?t=<?= filemtime(filename: 'public/app.js') ?>"></script>
    <script src="/refresh.js?t=<?= filemtime(filename: 'public/refresh.js') ?>"></script>
    <script>
        Translations['are you sure?'] = '<?= $translator->areYouSure() ?>';
    </script>
    <script src="/cookie.js?t=<?= filemtime(filename: 'public/cookie.js') ?>"></script>

    <script src="/vendor/fontawesome/js/all.js?t=<?= filemtime(filename: 'public/vendor/fontawesome/js/all.js') ?>"></script>
    <link href="/vendor/fontawesome/css/all.css?t=<?= filemtime(filename: 'public/vendor/fontawesome/css/all.css') ?>" media="screen" rel="stylesheet" type="text/css"/>

    <script src="/vendor/moment/moment.js?t=<?= filemtime(filename: 'public/vendor/moment/moment.js') ?>"></script>
    <script src="/vendor/moment/locales.js?t=<?= filemtime(filename: 'public/vendor/moment/locales.js') ?>"></script>

    <script src="/vendor/sortable.js?t=<?= filemtime(filename: 'public/vendor/sortable.js') ?>"></script>
    <script src="/vendor/chelsea.js?t=<?= filemtime(filename: 'public/vendor/chelsea.js') ?>"></script>
    <title>
       Do Every
        <?php if(true === isset($pageTitle)): ?>
            - <?= $pageTitle ?>
        <?php endif ?>
    </title>
    <style>
        @view-transition {
            navigation: auto;
        }
    </style>
</head>
<body>
    <div id="app">
        <div id="menu">
            <div id="logoContainer">
                <img id="logo" src="/bee.png" alt="logo">
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        animate('span.error', {
            translateY: [100, 0],          // Startet 20px tiefer und gleitet auf 0
            opacity: [0, 1],              // Von unsichtbar zu sichtbar
            delay: stagger(100),    // Jedes Element wartet 150ms länger als das vorherige
            duration: 1000,
            ease: 'outExpo'
        });
        animate('#messageContainer', {
            translateY: [2000, 0],          // Startet 20px tiefer und gleitet auf 0
            opacity: [0, 1],              // Von unsichtbar zu sichtbar
            delay: stagger(100),    // Jedes Element wartet 150ms länger als das vorherige
            duration: 1000,
            ease: 'outExpo'
        });
    });
</script>
</body>
</html>