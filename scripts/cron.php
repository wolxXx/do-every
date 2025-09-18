<?php
defined(constant_name: 'DISABLE_DOCTRINE_TOOLS') || define(constant_name: 'DISABLE_DOCTRINE_TOOLS', value: true);
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: 'start cron');
new \DoEveryApp\Util\Cron();
exec(command: 'rm /tmp/__CG*');
\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug(message: 'cron finished');
