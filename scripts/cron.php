<?php
defined(constant_name: 'DISABLE_DOCTRINE_TOOLS') || define(constant_name: 'DISABLE_DOCTRINE_TOOLS', value: true);
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

new \DoEveryApp\Util\Cron();
try {
    exec(command: 'rm /tmp/__CG*', output: $output, result_code: $resultCode);
} catch (\Throwable) {

}
