<?php

declare(strict_types=1);

namespace DoEveryAppTest\Views;


class BaseTest extends \DoEveryAppTest\TestBase
{
    public function testIndex()
    {
        $response    = (new \Slim\Psr7\Response());
        $phpRenderer = \DoEveryApp\Util\DependencyContainer::getInstance()->getRenderer();
        $phpRenderer->setAttributes(attributes: [
                                        'currentRoute'        => '',
                                        'currentRoutePattern' => '',
                                        'translator' => new \DoEveryApp\Util\Translator\German(),
                                    ]);
        $response = $phpRenderer->render(response: $response, template: 'action/cms/index.php');
        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();
        $this->assertTrue(condition: \str_contains(haystack: $body, needle: '<img src="/bee.png" alt="logo" style="max-width: 100px; max-height: 100px;">'));
    }
    public function testDashboard()
    {
        \DoEveryApp\Util\User\Current::$forcedLoggedInUser = (new \DoEveryApp\Entity\Worker())
        ->setId(id: 1)
        ;
        $response    = (new \Slim\Psr7\Response());
        $phpRenderer = \DoEveryApp\Util\DependencyContainer::getInstance()->getRenderer();
        $phpRenderer->setAttributes(attributes: [
                                        'currentRoute'        => '',
                                        'currentRoutePattern' => '',
                                        'translator' => new \DoEveryApp\Util\Translator\German(),
                                        'currentUser' => \DoEveryApp\Util\User\Current::$forcedLoggedInUser,
                                    ]);
        $response = $phpRenderer->render(response: $response, template: 'action/cms/dashboard.php', data: [
            'tasks' => [],
            'disabledTasks' => [],
            'workingOn' => [],
            'workers' => [],
            'groups' => [],
            'tasksWithoutGroup' => [],
            'dueTasks' => [],
            'executions' => [],
        ]);
        $response->getBody()->rewind();
        $body = $response->getBody()->getContents();
        $this->assertTrue(condition: \str_contains(haystack: $body, needle: '<img src="/bee.png" alt="logo" style="max-width: 100px; max-height: 100px;">'));
    }
}