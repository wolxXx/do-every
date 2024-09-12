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

        $debugFiles = [];
        $path      = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'backups' . \DIRECTORY_SEPARATOR;
        $Directory = new \RecursiveDirectoryIterator($path);
        $Iterator  = new \RecursiveIteratorIterator($Directory);
        $Regex     = new \RegexIterator($Iterator, '/^.+\.sql/i', \RegexIterator::GET_MATCH);
        foreach ($Regex as $files) {
            foreach ($files as $file) {
                $realPath = \realpath($file);
                $debugFiles[] = $realPath;
            }
        }
        sort($debugFiles);

        return $this->render('action/cms/debug', ['debugFiles' => $debugFiles]);
    }
}