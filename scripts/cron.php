<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

\DoEveryApp\Util\DependencyContainer::getInstance()
    ->getLogger()
    ->debug('bar');

echo "foo";