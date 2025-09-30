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
$menuItem = new \DoEveryApp\Util\View\MenuItem()
    ->setCurrentRoute(currentRoute: $currentRoute)
    ->setCurrentRoutePattern(currentRoutePattern: $currentRoutePattern)
;
?>
<ul>

    <?php if (false === \DoEveryApp\Util\User\Current::isAuthenticated()): ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Cms\IndexAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Cms\IndexAction::getRoutePattern(),
                              ])
            ->setName(name: 'Start')
        ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Auth\LoginAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Auth\LoginAction::getRoutePattern(),
                              ])
            ->setName(name: 'einloggen')
        ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Auth\RequirePasswordResetTokenAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Auth\RequirePasswordResetTokenAction::getRoutePattern(),
                              ])
            ->setName(name: 'Passwort vergessen')
        ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::getRoutePattern(),
                              ])
            ->setName(name: 'Code eingeben')
        ?>
    <?php endif ?>

    <?php if (true === \DoEveryApp\Util\User\Current::isAuthenticated()): ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Cms\IndexAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Cms\IndexAction::getRoutePattern(),
                              ])
            ->setName(name: $translator->dashboard())
        ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Task\IndexAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
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
            ->setName(name: $translator->tasks())
        ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Task\LogAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Task\LogAction::getRoutePattern(),
                              ])
            ->setName(name: 'Log')
        ?>
        <?php if (true === \DoEveryApp\Util\Registry::getInstance()->doUseTimer()): ?>
            <?= $menuItem
                ->setTarget(target: \DoEveryApp\Action\Task\Timer\IndexAction::getRoute())
                ->setActiveRoutes(activeRoutes: [
                                      \DoEveryApp\Action\Task\Timer\IndexAction::getRoutePattern(),
                                  ])
                ->setName(name: $translator->timer())
            ?>
        <?php endif ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Worker\IndexAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Worker\AddAction::getRoutePattern(),
                                  \DoEveryApp\Action\Worker\EditAction::getRoutePattern(),
                                  \DoEveryApp\Action\Worker\IndexAction::getRoutePattern(),
                                  \DoEveryApp\Action\Worker\LogAction::getRoutePattern(),
                                  \DoEveryApp\Action\Worker\EnableTwoFactorAction::getRoutePattern(),
                              ])
            ->setName(name: $translator->workers())
        ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Cms\ShowSettingsAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Cms\ShowSettingsAction::getRoutePattern(),
                                  \DoEveryApp\Action\Cms\EditSettingsAction::getRoutePattern(),
                              ])
            ->setName(name: $translator->settings())
        ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Cms\DebugAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Cms\DebugAction::getRoutePattern(),
                              ])
            ->setName(name: 'debug')
        ?>
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Cms\HelpAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Cms\HelpAction::getRoutePattern(),
                              ])
            ->setName(name: $translator->help())
        ?>
        <hr />
        <?= $menuItem
            ->setTarget(target: \DoEveryApp\Action\Auth\LogoutAction::getRoute())
            ->setActiveRoutes(activeRoutes: [
                                  \DoEveryApp\Action\Auth\LogoutAction::getRoutePattern(),
                              ])
            ->setName(name: $translator->logout())
        ?>
    <?php endif ?>
</ul>