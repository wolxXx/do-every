<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
chdir(dirname(__DIR__));
defined('ROOT_DIR') || define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..');

ini_set('xdebug.var_display_max_depth', 10);
ini_set('xdebug.var_display_max_children', 100);
ini_set('xdebug.var_display_max_data', 100);


$app = \Slim\Factory\AppFactory::create();
$app->addErrorMiddleware(true, false, false);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
    ;
});

foreach (\DoEveryApp\Entity\Execution::getRepository()->findAll() as $execution) {
    \DoEveryApp\Util\Debugger::debug($execution->getId());
}
foreach (\DoEveryApp\Entity\Notification::getRepository()->findAll() as $notification) {
    \DoEveryApp\Util\Debugger::debug($notification->getId());
}
foreach (\DoEveryApp\Entity\Task::getRepository()->findAll() as $task) {
    \DoEveryApp\Util\Debugger::debug($task->getId());
}
foreach (\DoEveryApp\Entity\Worker::getRepository()->findAll() as $worker) {
    \DoEveryApp\Util\Debugger::debug($worker->getId());
}
\DoEveryApp\Util\Debugger::dieDebug('alive');