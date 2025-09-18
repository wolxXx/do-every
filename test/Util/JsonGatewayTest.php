<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util;


class JsonGatewayTest extends \DoEveryAppTest\TestBase
{
    public function testInstantiation()
    {
        $expectedJson = '{
  "true": "false"
}';
        $response = new \Slim\Psr7\Factory\ResponseFactory()->createResponse(code: 200);
        $statusCode = 333;
        $response = \DoEveryApp\Util\JsonGateway::Factory(response: $response, data: ['true' => 'false'], code: $statusCode);
        $this->assertSame(expected: $statusCode, actual: $response->getStatusCode());
        $this->assertSame(expected: $expectedJson, actual: $response->getBody()->getContents());
    }
}