<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

echo \Ramsey\Uuid\Uuid::uuid4()->toString();
echo PHP_EOL;
echo PHP_EOL;
exit(0);