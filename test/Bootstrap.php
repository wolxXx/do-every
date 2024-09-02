<?php

namespace DoEveryAppTest;


error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
if (false === defined('IS_IN_TEST_ENV')) {
    define('IS_IN_TEST_ENV', true);
}
defined('ROOT_DIR') || define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..' );
require_once __DIR__ . '/TestBase.php';
ini_alter('xdebug.var_display_max_data', '1000000');
ini_alter('xdebug.var_display_max_children', '1000000');
ini_alter('xdebug.var_display_max_depth', '1000000');

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
        chdir(__DIR__ . \DIRECTORY_SEPARATOR . '..');
    }
}

Bootstrap::init();
Bootstrap::chroot();