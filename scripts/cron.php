<?php
defined('DISABLE_DOCTRINE_TOOLS') || define('DISABLE_DOCTRINE_TOOLS', true);
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug('start cron');
new \DoEveryApp\Util\Cron();
exec('rm /tmp/__CG*');
\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug('cron finished');
