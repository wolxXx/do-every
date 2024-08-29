<?php
/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $content             string
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 */
$menuItem = (new \DoEveryApp\Util\View\MenuItem())
    ->setCurrentRoute($currentRoute)
    ->setCurrentRoutePattern($currentRoutePattern)
;
?>
<ul>
    <?= $menuItem
        ->setTarget(\DoEveryApp\Action\Cms\IndexAction::getRoute())
        ->setActiveRoutes([
                              \DoEveryApp\Action\Cms\IndexAction::getRoutePattern(),
                          ])
        ->setName('START')
    ?>
    
    <? if (false === \DoEveryApp\Util\User\Current::isAuthenticated()): ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Auth\LoginAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Auth\LoginAction::getRoutePattern(),
                              ])
            ->setName('EINLOGGEN')
        ?>
    <? endif ?>
    
    <? if (true === \DoEveryApp\Util\User\Current::isAuthenticated()): ?>
        <li>
            [aufgaben]
        </li>
        <li>
            [worker]
        </li>
        <li>
            [kalender]
        </li>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Auth\LogoutAction::getRoute())
            ->setName('AUSLOGGEN')
        ?>
    <? endif ?>
</ul>