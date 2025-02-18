<?php
define(constant_name: 'STARTED', value: microtime(as_float: true));
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
chdir(directory: dirname(path: __DIR__));
defined(constant_name: 'ROOT_DIR') || define(constant_name: 'ROOT_DIR', value: __DIR__ . DIRECTORY_SEPARATOR . '..');

ini_set(option: 'xdebug.var_display_max_depth', value: 10);
ini_set(option: 'xdebug.var_display_max_children', value: 100);
ini_set(option: 'xdebug.var_display_max_data', value: 100);

ini_set(option: 'opcache.memory_consumption', value: 2048);
ini_set(option: 'opcache.interned_strings_buffer', value: 8);
ini_set(option: 'opcache.max_accelerated_files', value: 4000);
ini_set(option: 'opcache.revalidate_freq', value: 60);
ini_set(option: 'opcache.enable_cli', value: 1);
ini_set('opcache.enable', 0);
ini_set(option: 'opcache.max_file_size', value: 1000);
ini_set(option: 'opcache.file_cache_only', value: 1);
ini_set(option: 'opcache.file_cache', value: ROOT_DIR . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . '.opcache');

//\DoEveryApp\Util\QueryLogger::$disabled = false;
\DoEveryApp\Util\QueryLogger::$disabled = true;

$app = \Slim\Factory\AppFactory::create();
$app->addErrorMiddleware(displayErrorDetails: true, logErrors: true, logErrorDetails: true, logger: \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger());

$app->options(pattern: '/{routes:.+}', callable: function ($request, $response, $args) {
    return $response;
});

$app->add(middleware: function ($request, $handler) {
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

$Directory = new \RecursiveDirectoryIterator(directory: \ROOT_DIR . \DIRECTORY_SEPARATOR . 'src' . \DIRECTORY_SEPARATOR . 'Action');
$Iterator  = new \RecursiveIteratorIterator(iterator: $Directory);
$Regex     = new \RegexIterator(iterator: $Iterator, pattern: '/^.+\.php$/i', mode: \RegexIterator::GET_MATCH);
foreach ($Regex as $files) {
    foreach ($files as $file) {
        $file  = \str_replace(search: \ROOT_DIR . \DIRECTORY_SEPARATOR . 'src', replace: '\\DoEveryApp', subject: $file);
        $file  = \str_replace(search: '/', replace: '\\', subject: $file);
        $file  = \str_replace(search: '.php', replace: '', subject: $file);
        $class = $file;
        if (false === \class_exists(class: $class)) {
            continue;
        }
        $reflection = new \ReflectionClass(objectOrClass: $class);
        $attributes = $reflection->getAttributes(name: \DoEveryApp\Attribute\Action\Route::class);
        foreach ($attributes as $attribute) {
            $className = $attribute->getName();
            $app->map(methods: $attribute->getArguments()['methods'], pattern: $attribute->getArguments()['path'], callable: $class . ':direct');
        }
    }
}

$app->map(methods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], pattern: '/{routes:.+}', callable: function ($request, $response): void {
    throw new \Slim\Exception\HttpNotFoundException(request: $request);
});

$app->run();