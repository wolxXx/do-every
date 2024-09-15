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
            ->setName($translator->dashboard())
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Task\IndexAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Task\IndexAction::getRoutePattern(),
                                  \DoEveryApp\Action\Task\AddAction::getRoutePattern(),
                                  \DoEveryApp\Action\Task\EditAction::getRoutePattern(),
                                  \DoEveryApp\Action\Task\ShowAction::getRoutePattern(),
                                  \DoEveryApp\Action\Execution\AddAction::getRoutePattern(),
                                  \DoEveryApp\Action\Execution\EditAction::getRoutePattern(),
                                  \DoEveryApp\Action\Group\AddAction::getRoutePattern(),
                                  \DoEveryApp\Action\Group\EditAction::getRoutePattern(),
                                  \DoEveryApp\Action\Group\ShowAction::getRoutePattern(),
                              ])
            ->setName($translator->tasks())
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Task\LogAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Task\LogAction::getRoutePattern(),
                              ])
            ->setName('Log')
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Worker\IndexAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Worker\IndexAction::getRoutePattern(),
                              ])
            ->setName($translator->workers())
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Cms\ShowSettingsAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Cms\ShowSettingsAction::getRoutePattern(),
                                  \DoEveryApp\Action\Cms\EditSettingsAction::getRoutePattern(),
                              ])
            ->setName($translator->settings())
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Cms\DebugAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Cms\DebugAction::getRoutePattern(),
                              ])
            ->setName('debug')
        ?>
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Auth\LogoutAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Auth\LogoutAction::getRoutePattern(),
                              ])
            ->setName($translator->logout())
        ?>
    <? endif ?>
</ul>