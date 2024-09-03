<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

\DoEveryApp\Util\DependencyContainer::getInstance()
    ->getLogger()
    ->debug('bar');

echo "foo";
echo "foo";
echo "foo";
echo "foo";

\DoEveryApp\Util\Debugger::debug('asdf');