<?php

declare(strict_types=1);

/**
 * @var $this                \Slim\Views\PhpRenderer
 * @var $errorStore          \DoEveryApp\Util\ErrorStore
 * @var $currentRoute        string
 * @var $currentRoutePattern string
 * @var $currentUser         \DoEveryApp\Entity\Worker|null
 */
$menuItem = (new \DoEveryApp\Util\View\MenuItem())
    ->setCurrentRoute($currentRoute)
    ->setCurrentRoutePattern($currentRoutePattern)
;
?>
<ul>
    
    <? if (false === \DoEveryApp\Util\User\Current::isAuthenticated()): ?>

        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Cms\IndexAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Cms\IndexAction::getRoutePattern(),
                              ])
            ->setName('Start')
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Auth\LoginAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Auth\LoginAction::getRoutePattern(),
                              ])
            ->setName('einloggen')
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Auth\RequirePasswordResetTokenAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Auth\RequirePasswordResetTokenAction::getRoutePattern(),
                              ])
            ->setName('Passwort vergessen')
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::getRoutePattern(),
                              ])
            ->setName('Code eingeben')
        ?>
    <? endif ?>
    
    <? if (true === \DoEveryApp\Util\User\Current::isAuthenticated()): ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Cms\IndexAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Cms\IndexAction::getRoutePattern(),
                              ])
            ->setName('Dashboard')
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Task\IndexAction::getRoute())
            ->setName('Aufgaben')
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Task\LogAction::getRoute())
            ->setName('Log')
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Worker\IndexAction::getRoute())
            ->setName('Worker')
        ?>
        <li>
            [kalender]
        </li>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Auth\LogoutAction::getRoute())
            ->setName('ausloggen')
        ?>
    <? endif ?>
</ul>