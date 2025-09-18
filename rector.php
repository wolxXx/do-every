<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;


/*return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(AddNamedArgumentsRector::class);
};*/

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/configs',
        __DIR__ . '/public',
        __DIR__ . '/scripts',
        __DIR__ . '/src',
        __DIR__ . '/test',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
        ->withSkipPath(
            './src/Util/Session.php'
    )
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0)
    ->withRules([
                    \SavinMikhail\AddNamedArgumentsRector\AddNamedArgumentsRector::class
                ])
;
