<?php
define('STARTED', microtime(true));
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
chdir(dirname(__DIR__));
defined('ROOT_DIR') || define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..');

ini_set('xdebug.var_display_max_depth', 10);
ini_set('xdebug.var_display_max_children', 100);
ini_set('xdebug.var_display_max_data', 100);

ini_set('opcache.memory_consumption', 2048);
ini_set('opcache.interned_strings_buffer', 8);
ini_set('opcache.max_accelerated_files', 4000);
ini_set('opcache.revalidate_freq', 60);
ini_set('opcache.enable_cli', 1);
//ini_set('opcache.enable', 0);
ini_set('opcache.max_file_size', 1000);
ini_set('opcache.file_cache_only', 1);
ini_set('opcache.file_cache', ROOT_DIR . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . '.opcache');

//\DoEveryApp\Util\QueryLogger::$disabled = false;
\DoEveryApp\Util\QueryLogger::$disabled = true;

$app = \Slim\Factory\AppFactory::create();
$app->addErrorMiddleware(true, true, true, \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger());

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
/*
$router = new \Tarikweiss\SlimAttributeRouter\Router(
    [ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Action'],
    new \Tarikweiss\SlimAttributeRouter\PublicMethodRouteTargetCreator('direct')
);
$router->registerRoutes($app);*/

$Directory = new \RecursiveDirectoryIterator(\ROOT_DIR . \DIRECTORY_SEPARATOR . 'src' . \DIRECTORY_SEPARATOR . 'Action');
$Iterator  = new \RecursiveIteratorIterator($Directory);
$Regex     = new \RegexIterator($Iterator, '/^.+\.php$/i', \RegexIterator::GET_MATCH);
foreach ($Regex as $files) {
    foreach ($files as $file) {
        $file  = \str_replace(\ROOT_DIR . \DIRECTORY_SEPARATOR . 'src', '\\DoEveryApp', $file);
        $file  = \str_replace('/', '\\', $file);
        $file  = \str_replace('.php', '', $file);
        $class = $file;
        if (false === \class_exists($class)) {
            continue;
        }
        $reflection = new \ReflectionClass($class);
        $attributes = $reflection->getAttributes(\DoEveryApp\Attribute\Action\Route::class);
        foreach ($attributes as $attribute) {
            $className = $attribute->getName();
            $app->map($attribute->getArguments()['methods'], $attribute->getArguments()['path'], $class . ':direct');
        }
    }
}

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response): void {
    throw new \Slim\Exception\HttpNotFoundException($request);
});

$app->run();