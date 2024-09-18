<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Debugger
{
    #[\JetBrains\PhpStorm\NoReturn]
    public static function dieDebug(...$debug): void
    {
        foreach (func_get_args() as $current) {
            self::debug($current);
        }
        die('die debug called. stopping here...' . PHP_EOL);
    }


    public static function debug(...$debug): void
    {
        $backtrace = debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT);
        $trace     = $backtrace[0];
        if (__FILE__ === $trace['file']) {
            $trace = $backtrace[1];
        }
        $line = $trace['line'] ?? 666;
        $file = $trace['file'] ?? 'somewhere';
        $pre  = '';
        $post = '';
        $last = PHP_EOL . '____________________' . PHP_EOL . PHP_EOL;
        if (false === self::isCli()) {
            $pre  = '<div class="debug" style="border: solid 2px #000; margin: 5px; padding: 10px; background: #eee;"><pre>';
            $post = '</pre>';
            $last = '</div>';
        }
        $text = 'debug from ' . (str_replace(getcwd(), '', $file)) . ' line ' . $line . ':' . PHP_EOL;
        echo sprintf('%s%s%s', $pre, $text, $post);
        foreach (func_get_args() as $arg) {
            var_dump($arg);
            echo PHP_EOL;
            echo PHP_EOL;
            echo '<hr>';
            print_r($arg);
        }
        echo $last;
    }


    public static function isCli(): bool
    {
        return 'cli' === php_sapi_name();
    }
}
