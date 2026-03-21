<?php
defined(constant_name: 'DISABLE_DOCTRINE_TOOLS') || define(constant_name: 'DISABLE_DOCTRINE_TOOLS', value: true);
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message:'Cron started');

try {
    \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message:'removing old cache files');
    exec(command: 'rm /tmp/__CG*', output: $output, result_code: $resultCode);
} catch (\Throwable) {

}

\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message:'launching cron manager');
new \DoEveryApp\Util\Cron();
\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message:'cron manager finished');
try {
    \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message:'removing old cache files');
    exec(command: 'rm /tmp/__CG*', output: $output, result_code: $resultCode);
} catch (\Throwable) {

}

\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message:'Cron finished');