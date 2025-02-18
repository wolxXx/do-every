<?php

namespace DoEveryAppTest;


error_reporting(error_level: E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
if (false === defined(constant_name: 'IS_IN_TEST_ENV')) {
    define(constant_name: 'IS_IN_TEST_ENV', value: true);
}
defined(constant_name: 'ROOT_DIR') || define(constant_name: 'ROOT_DIR', value: __DIR__ . DIRECTORY_SEPARATOR . '..' );
require_once __DIR__ . '/TestBase.php';
ini_set(option: 'xdebug.var_display_max_data', value: '1000000');
ini_set(option: 'xdebug.var_display_max_children', value: '1000000');
ini_set(option: 'xdebug.var_display_max_depth', value: '1000000');
ini_set(option: 'zend.exception_ignore_args', value: '1');
\DoEveryApp\Util\QueryLogger::$disabled = true;
class Bootstrap
{

    public static function init(): void
    {
        static::initAutoloader();
    }


    protected static function initAutoloader(): void
    {
        require_once __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
    }
    

    public static function chroot(): void
    {
        chdir(directory: __DIR__ . \DIRECTORY_SEPARATOR . '..');
    }
}

Bootstrap::init();
Bootstrap::chroot();