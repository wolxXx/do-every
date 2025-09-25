<?php

declare(strict_types=1);

namespace DoEveryAppTest\Views\Action\Auth;

class LoginTest extends \DoEveryAppTest\Views\ViewTestBase
{
    public function testWithEmptyData()
    {
        $result = $this->render(
            templateName: 'action/auth/login.php',
        );
        $this->assertSame(expected: 200, actual: $result->responseCode);
        $this->assertSame(expected: 'text/html', actual: $result->responseObject->getHeaderLine(name: 'Content-Type'));
        $this->assertStringContainsString(needle: 'E-Mail', haystack: $result->responseBody);;
        $this->assertStringContainsString(needle: 'Passwort', haystack: $result->responseBody);;
        $this->assertStringContainsString(needle: 'los', haystack: $result->responseBody);;
    }
}
