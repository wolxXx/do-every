<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/download-backup/{path}/',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ]
)]
class DownloadBackupAction extends \DoEveryApp\Action\AbstractAction
{
    public static function getRoute(string $path): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getAttributes(\DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            return \str_replace('{path}', $path, $attribute->getArguments()['path']);
        }

        throw new \RuntimeException('Could not determine route path');
    }

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $requestedFile = \base64_decode($this->getArgumentSafe('path'));
        if ('all' === $requestedFile) {
            try {
                $zip = new \ZipArchive();;
                $filename = \tempnam(sys_get_temp_dir(), 'backup_') . '.zip';
                if (true !== $zip->open($filename, \ZipArchive::CREATE)) {
                    throw new \RuntimeException('Could not open temp file');
                }
                $path      = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'backups' . \DIRECTORY_SEPARATOR;
                $Directory = new \RecursiveDirectoryIterator($path);
                $Iterator  = new \RecursiveIteratorIterator($Directory);
                $Regex     = new \RegexIterator($Iterator, '/^.+\.sql/i', \RegexIterator::GET_MATCH);
                foreach ($Regex as $files) {
                    foreach ($files as $file) {
                        $realPath = \realpath($file);
                        $zip->addFile($realPath, \str_replace(\realpath(\ROOT_DIR), '', $realPath));
                    }
                }

                $zip->close();
                $fileContent = file_get_contents($filename);
                $stream      = \GuzzleHttp\Psr7\Utils::streamFor($fileContent);
                $response    = $this->getResponse()->withBody($stream);
                $response    = $response
                    ->withAddedHeader('Content-Type', \mime_content_type($filename))
                    ->withAddedHeader('Content-Transfer-Encoding', 'binary')
                    ->withAddedHeader('Content-Length', \filesize($filename))
                    ->withAddedHeader('Cache-Control', 'proxy-revalidate, must-revalidate, no-cache, no-store')
                    ->withAddedHeader('Pragma', 'no-cache')
                    ->withAddedHeader('Content-Disposition', 'attachment; filename="backup.zip"')
                ;
                $this->setResponse($response);
                \unlink($filename);

                return $this->getResponse();
            } catch (\Exception $exception) {
                \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

                return $this->redirect(IndexAction::getRoute());
            }
        }

        $filePath = \ROOT_DIR . $requestedFile;
        if (false === \file_exists($filePath)) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

            return $this->redirect(IndexAction::getRoute());
        }

        try {
            $fileContent = file_get_contents($filePath);
            $stream      = \GuzzleHttp\Psr7\Utils::streamFor($fileContent);
            $response    = $this->getResponse()->withBody($stream);
            $response    = $response
                ->withAddedHeader('Content-Type', \mime_content_type($filePath))
                ->withAddedHeader('Content-Transfer-Encoding', 'binary')
                ->withAddedHeader('Content-Length', \filesize($filePath))
                ->withAddedHeader('Cache-Control', 'proxy-revalidate, must-revalidate, no-cache, no-store')
                ->withAddedHeader('Pragma', 'no-cache')
                ->withAddedHeader('Content-Disposition', 'attachment; filename="' . \basename($requestedFile) . '"')
            ;
            $this->setResponse($response);

            return $this->getResponse();
        } catch (\Exception $exception) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

            return $this->redirect(IndexAction::getRoute());
        }
    }
}
