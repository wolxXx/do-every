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

        $this->assertSame(\PHP_EOL.'hallo!', $result->responseBody);
    }
    public function testDashboard()
    {
        $registry = \DoEveryApp\Util\Registry::getInstance()->setDoFillTimeLine(fillTimeLine: true);
        $this->assertTrue(\DoEveryApp\Util\Registry::getInstance()->doFillTimeLine());
        \Carbon\Carbon::setTestNow('2010-01-01 00:00:00');

        $result = $this->render(
            templateName: 'action/cms/dashboard.php',
            data        : [
                              'tasks'             => [],
                              'disabledTasks'     => [],
                              'workingOn'         => [],
                              'workers'           => [],
                              'groups'            => [],
                              'tasksWithoutGroup' => [],
                              'dueTasks'          => [],
                              'executions'        => [],
                              'currentUser'       => $this->getDefaultUser(),
                          ],
            worker      : $this->getDefaultUser()
        );


        $html2Text = new \Html2Text\Html2Text();
        $html2Text->setHtml($result->responseBody);
        $text      = $html2Text->getText();

        $this->assertStringContainsString(needle: 'DASHBOARD', haystack: $text);
    }
}