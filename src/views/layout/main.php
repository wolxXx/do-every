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
</head>
<body>
    <div id="app">
        <div id="menu">
            <div style="text-align: right">
                <img src="/bee.png" alt="logo" style="max-width: 100px; max-height: 100px;">

                <svg
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 200 200"
                        width="200" height="200">

                    <!-- Äußere Uhr -->
                    <circle cx="100" cy="100" r="60" stroke="#ac1212" stroke-width="8" fill="none" />

                    <!-- Obere Knöpfe -->
                    <rect x="85" y="25" width="12" height="10" fill="#ac1212" />
                    <rect x="105" y="25" width="12" height="10" fill="#ac1212" />

                    <!-- Innere Uhr -->
                    <circle cx="100" cy="100" r="50" stroke="#ac1212" stroke-width="4" fill="none" />

                    <!-- Markierungen -->
                    <line x1="100" y1="50" x2="100" y2="55" stroke="#ac1212" stroke-width="4" />
                    <line x1="100" y1="145" x2="100" y2="150" stroke="#ac1212" stroke-width="4" />
                    <line x1="55" y1="100" x2="50" y2="100" stroke="#ac1212" stroke-width="4" />
                    <line x1="145" y1="100" x2="150" y2="100" stroke="#ac1212" stroke-width="4" />

                    <!-- Zeiger -->
                    <line x1="100" y1="100" x2="120" y2="80" stroke="#ac1212" stroke-width="6" stroke-linecap="round" />

                    <!-- Text "Do Every" -->
                    <text x="100" y="180" font-size="18" font-family="Arial, sans-serif" fill="#ac1212" text-anchor="middle">Do Every</text>
                </svg>
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