<?php

declare(strict_types=1);

namespace DoEveryAppTest\Views;

abstract class ViewTestBase extends \DoEveryAppTest\TestBase
{
    protected function getDefaultUser(): \DoEveryApp\Entity\Worker
    {
        return new \DoEveryApp\Entity\Worker()
            ->setName(name:'test user')
            ->setEmail(email: 'test-user@do-every.de')
            ->setId(id: 1)
            ;
    }
    protected function render(
        string $templateName,
        int $responseCode = 200,
        string $contentType = 'text/html',
        string $layoutName = 'layout/empty.php',
        ?\DoEveryApp\Util\Translator $translator = null,
        ?array $data = [],
        ?\DoEveryApp\Entity\Worker $worker = null,

    ): ViewTestResult
    {
        \DoEveryApp\Util\User\Current::$forcedLoggedInUser = $worker;
        $phpRenderer = \DoEveryApp\Util\DependencyContainer::getInstance()->getRenderer();
        $phpRenderer->setAttributes(attributes: [
                                                    'errorStore'          => new \DoEveryApp\Util\ErrorStore(),
                                                    'currentRoute'        => '/',
                                                    'currentRoutePattern' => '/',
                                                    'translator' => $translator ?? new \DoEveryApp\Util\Translator\German(),
                                                ]);

        $phpRenderer->setLayout(layout: $layoutName);;
        $result =
            $phpRenderer->render(
                response: new \Slim\Psr7\Response(
                              status: $responseCode,
                              headers: new \Slim\Psr7\Headers(headers: ['Content-Type' => $contentType]),
                          ),
                template: $templateName,
                data    : $data,
            );

        $body   = $result->getBody();
        $body->rewind();
        $contents = $body->getContents();
        return new ViewTestResult(
            responseCode  : $result->getStatusCode(),
            responseBody  : $contents,
            responseObject: $result
        );
    }
}