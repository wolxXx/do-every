<?php

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
        $backupFiles = [];
        $path        = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'backups' . \DIRECTORY_SEPARATOR;
        $Directory   = new \RecursiveDirectoryIterator($path);
        $Iterator    = new \RecursiveIteratorIterator($Directory);
        $Regex       = new \RegexIterator($Iterator, '/^.+\.sql/i', \RegexIterator::GET_MATCH);
        foreach ($Regex as $files) {
            foreach ($files as $file) {
                $realPath               = \realpath($file);
                $realPath               = \str_replace(\realpath(\ROOT_DIR), '', $realPath);
                $backupFiles[$realPath] = \filesize(\realpath($file));
            }
        }
        \krsort($backupFiles);

        return $this->render('action/cms/debug', ['backupFiles' => $backupFiles]);
    }
}