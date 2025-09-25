<?php

declare(strict_types=1);

namespace DoEveryAppTest\Views;


class BaseTest extends ViewTestBase
{
    public function testIndex()
    {
        $result = $this->render(
            templateName: 'action/cms/index.php',
        );

        $this->assertTrue(condition: \str_contains(haystack: $result->responseBody, needle: '<img src="/bee.png" alt="logo" style="max-width: 100px; max-height: 100px;">'));
    }
    public function testDashboard()
    {
        $result = $this->render(
            templateName: 'action/cms/dashboard.php',
            data        : [
                              'tasks' => [],
                              'disabledTasks' => [],
                              'workingOn' => [],
                              'workers' => [],
                              'groups' => [],
                              'tasksWithoutGroup' => [],
                              'dueTasks' => [],
                              'executions' => [],
                          ],
            worker      : $this->getDefaultUser()
        );

        $this->assertStringContainsString(needle: '<img src="/bee.png" alt="logo" style="max-width: 100px; max-height: 100px;">', haystack: $result->responseBody);
    }
}