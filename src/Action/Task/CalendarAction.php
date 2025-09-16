<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/calendar',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_HEAD,
        \Fig\Http\Message\RequestMethodInterface::METHOD_OPTIONS,
        \Fig\Http\Message\RequestMethodInterface::METHOD_TRACE,
        \Fig\Http\Message\RequestMethodInterface::METHOD_PUT,
        'PROPFIND',// lol
    ],
    authRequired: false,
)]
class CalendarAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        \DoEveryApp\Util\QueryLogger::$disabled = true;
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug('CalendarAction');
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(\Safe\json_encode($this->getRequest()->getHeaders(), JSON_PRETTY_PRINT));
        \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(\Safe\json_encode($this->getRequest()->getParsedBody(), JSON_PRETTY_PRINT));

        if (false === isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="Kalender"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Authentifizierung erforderlich';
            exit;
        }

        if ($_SERVER['PHP_AUTH_USER'] !== \DoEveryApp\Util\Registry::getInstance()->getDavUser() || $_SERVER['PHP_AUTH_PW'] !== \DoEveryApp\Util\Registry::getInstance()->getDavPassword()) {
            header('HTTP/1.0 403 Forbidden');
            echo 'Zugang verweigert';
            exit;
        }

        $calendar = new \Sabre\VObject\Component\VCalendar();
        foreach (\DoEveryApp\Entity\Task::getRepository()->findAllForIndex() as $task) {
            if (false === $task->isActive()) {
                continue;
            }
            $calendar->add('VEVENT', $task->toVCalendarEvent());
        }

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename="kalender.ics"');

        echo $calendar->serialize();

        die();
    }
}
