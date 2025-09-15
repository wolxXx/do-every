<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task;

use
    Sabre\DAV,
    Sabre\CalDAV,
    Sabre\DAVACL;


#[\DoEveryApp\Attribute\Action\Route(
    path   : '/calendar',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_HEAD,
        \Fig\Http\Message\RequestMethodInterface::METHOD_OPTIONS,
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

        $pdo = new \PDO('mysql:host=mysql;dbname=do_every', 'root', 'root');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //Mapping PHP errors to exceptions

        set_error_handler(function($errno, $errstr, $errfile, $errline ) {
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });


        // Backends
        $authBackend = new DAV\Auth\Backend\PDO($pdo);
        $principalBackend = new DAVACL\PrincipalBackend\PDO($pdo);
        $calendarBackend = new CalDAV\Backend\PDO($pdo);

        // Directory tree
        $tree = array(
            new DAVACL\PrincipalCollection($principalBackend),
            new CalDAV\CalendarRoot($principalBackend, $calendarBackend),
        );


        // The object tree needs in turn to be passed to the server class
        $server = new DAV\Server($tree);

        // You are highly encouraged to set your WebDAV server base url. Without it,
        // SabreDAV will guess, but the guess is not always correct. Putting the
        // server on the root of the domain will improve compatibility.
        $server->setBaseUri('/calendar');

        // Authentication plugin
        $authPlugin = new DAV\Auth\Plugin($authBackend,'SabreDAV');
        /*        $server->addPlugin($authPlugin);*/
        $authPlugin = new DAV\Auth\Plugin(new DAV\Auth\Backend\BasicCallBack(callBack: function($username, $password) {
            $requiredUsername = \DoEveryApp\Util\Registry::getInstance()->getDavUser();
            $requiredPassword = \DoEveryApp\Util\Registry::getInstance()->getDavPassword();
            if (null === $requiredUsername || null === $requiredPassword) {
                return false;
            }
            return (
                $username === $requiredUsername &&
                $password === $requiredPassword
            );
        }));
        $server->addPlugin(plugin: $authPlugin);

        // CalDAV plugin
        $caldavPlugin = new CalDAV\Plugin();
        $server->addPlugin($caldavPlugin);
/*

        // ACL plugin
        $aclPlugin = new DAVACL\Plugin();
        $server->addPlugin($aclPlugin);

        // Support for html frontend
        $browser = new DAV\Browser\Plugin();
        $server->addPlugin($browser);*/

        // And off we go!
        $server->start();

        \DoEveryApp\Util\Debugger::dieDebug('omfg');
    }
}
