<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

\DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->debug('start cron');
new \DoEveryApp\Util\Cron();
