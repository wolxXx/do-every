<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$newHeader = <<<PHP
<?php

declare(strict_types=1);

/**
 * @var \Slim\Views\PhpRenderer        \$this
 * @var \DoEveryApp\Util\ErrorStore    \$errorStore
 * @var string                         \$currentRoute
 * @var string                         \$currentRoutePattern
 * @var \DoEveryApp\Entity\Worker|null \$currentUser
 * @var \DoEveryApp\Util\Translator    \$translator
PHP;

$directoryIterator = new \RecursiveDirectoryIterator(directory: ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'views');
$iterator          = new \RecursiveIteratorIterator(iterator: $directoryIterator);
$regexIterator     = new \RegexIterator(iterator: $iterator, pattern: '/^.+\.php$/i', mode: \RecursiveRegexIterator::GET_MATCH);
foreach ($regexIterator as $current) {
    $file    = $current[0];
    $path    = realpath(path: $file);
    $content = file_get_contents(filename: $path);
    $until   = ' */';
    while (true) {
        $firstLine = explode(separator: "\n", string: $content, limit: 2)[0];
        $content   = substr(string: $content, offset: strpos(haystack: $content, needle: "\n") + 1);
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

    file_put_contents(filename: $path, data: $content);
}
