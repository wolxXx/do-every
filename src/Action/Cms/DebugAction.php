<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/debug',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ]
)]
class DebugAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        \opcache_reset();
        $backupFiles = [];
        $path        = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'backups' . \DIRECTORY_SEPARATOR;
        $Directory   = new \RecursiveDirectoryIterator(directory: $path);
        $Iterator    = new \RecursiveIteratorIterator(iterator: $Directory);
        $Regex       = new \RegexIterator(iterator: $Iterator, pattern: '/^.+\.sql/i', mode: \RegexIterator::GET_MATCH);
        foreach ($Regex as $files) {
            foreach ($files as $file) {
                $realPath               = \realpath(path: $file);
                $realPath               = \str_replace(search: \realpath(path: \ROOT_DIR), replace: '', subject: $realPath);
                $backupFiles[$realPath] = \filesize(filename: \realpath(path: $file));
            }
        }
        \krsort(array: $backupFiles);

        return $this->render(script: 'action/cms/debug', data: ['backupFiles' => $backupFiles]);
    }
}
