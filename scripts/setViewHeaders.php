<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$newHeader = <<<PHP
<?php

declare(strict_types=1);

/**
 * @var \$this                \Slim\Views\PhpRenderer
 * @var \$errorStore          \DoEveryApp\Util\ErrorStore
 * @var \$currentRoute        string
 * @var \$currentRoutePattern string
 * @var \$currentUser         \DoEveryApp\Entity\Worker|null
 * @var \$translator          \DoEveryApp\Util\Translator
PHP;

$directoryIterator = new \RecursiveDirectoryIterator(ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'views');
$iterator          = new \RecursiveIteratorIterator($directoryIterator);
$regexIterator     = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);
foreach ($regexIterator as $current) {
    $file    = $current[0];
    $path    = realpath($file);
    $content = file_get_contents($path);
    $until   = ' */';
    while (true) {
        $firstLine = explode("\n", $content, 2)[0];
        $content   = substr($content, strpos($content, "\n") + 1);
        if ($until === $firstLine) {
            break;
        }
        if ('' === $content) {
            \DoEveryApp\Util\Debugger::debug($path);
            //something went really really wrong xD
            die('OMFG!!!');
        }
    }

    $content = $newHeader . PHP_EOL . $until . PHP_EOL . $content;

    file_put_contents($path, $content);
}
