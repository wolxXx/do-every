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
$menuItem = (new \DoEveryApp\Util\View\MenuItem())
    ->setCurrentRoute($currentRoute)
    ->setCurrentRoutePattern($currentRoutePattern)
;
?>
<ul>

    <?php if (false === \DoEveryApp\Util\User\Current::isAuthenticated()): ?>
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
    <?php endif ?>

    <?php if (true === \DoEveryApp\Util\User\Current::isAuthenticated()): ?>
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
                                  \DoEveryApp\Action\Worker\AddAction::getRoutePattern(),
                                  \DoEveryApp\Action\Worker\EditAction::getRoutePattern(),
                                  \DoEveryApp\Action\Worker\IndexAction::getRoutePattern(),
                                  \DoEveryApp\Action\Worker\LogAction::getRoutePattern(),
                                  \DoEveryApp\Action\Worker\EnableTwoFactorAction::getRoutePattern(),
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
            ->setTarget(\DoEveryApp\Action\Cms\HelpAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Cms\HelpAction::getRoutePattern(),
                              ])
            ->setName($translator->help())
        ?>
        <hr />
        <?= $menuItem
            ->setTarget(\DoEveryApp\Action\Auth\LogoutAction::getRoute())
            ->setActiveRoutes([
                                  \DoEveryApp\Action\Auth\LogoutAction::getRoutePattern(),
                              ])
            ->setName($translator->logout())
        ?>
    <?php endif ?>
</ul>