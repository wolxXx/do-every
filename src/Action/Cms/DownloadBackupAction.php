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
        $reflection = new \ReflectionClass(objectOrClass: __CLASS__);
        foreach ($reflection->getAttributes(name: \DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            return \str_replace(search: '{path}', replace: $path, subject: $attribute->getArguments()['path']);
        }

        throw new \RuntimeException(message: 'Could not determine route path');
    }

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        \DoEveryApp\Util\QueryLogger::$disabled = true;
        $requestedFile = \base64_decode(string: $this->getArgumentSafe(argumentName: 'path'));
        if ('all' === $requestedFile) {
            try {
                $zip = new \ZipArchive();;
                $filename = \tempnam(directory: sys_get_temp_dir(), prefix: 'backup_') . '.zip';
                if (true !== $zip->open(filename: $filename, flags: \ZipArchive::CREATE)) {
                    throw new \RuntimeException(message: 'Could not open temp file');
                }
                $path      = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'backups' . \DIRECTORY_SEPARATOR;
                $Directory = new \RecursiveDirectoryIterator(directory: $path);
                $Iterator  = new \RecursiveIteratorIterator(iterator: $Directory);
                $Regex     = new \RegexIterator(iterator: $Iterator, pattern: '/^.+\.sql/i', mode: \RegexIterator::GET_MATCH);
                foreach ($Regex as $files) {
                    foreach ($files as $file) {
                        $realPath = \realpath(path: $file);
                        $zip->addFile(filepath: $realPath, entryname: \str_replace(search: \realpath(path: \ROOT_DIR), replace: '', subject: $realPath));
                    }
                }

                $zip->close();
                $fileContent = file_get_contents(filename: $filename);
                $stream      = \GuzzleHttp\Psr7\Utils::streamFor(resource: $fileContent);
                $response    = $this->getResponse()->withBody(body: $stream);
                $response    = $response
                    ->withAddedHeader(name: 'Content-Type', value: \mime_content_type(filename: $filename))
                    ->withAddedHeader(name: 'Content-Transfer-Encoding', value: 'binary')
                    ->withAddedHeader(name: 'Content-Length', value: \filesize(filename: $filename))
                    ->withAddedHeader(name: 'Cache-Control', value: 'proxy-revalidate, must-revalidate, no-cache, no-store')
                    ->withAddedHeader(name: 'Pragma', value: 'no-cache')
                    ->withAddedHeader(name: 'Content-Disposition', value: 'attachment; filename="backup.zip"')
                ;
                $this->setResponse(response: $response);
                \unlink(filename: $filename);

                return $this->getResponse();
            } catch (\Exception) {
                \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

                return $this->redirect(to: IndexAction::getRoute());
            }
        }

        $filePath = \ROOT_DIR . $requestedFile;
        if (false === \file_exists(filename: $filePath)) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

            return $this->redirect(to: IndexAction::getRoute());
        }

        try {
            $fileContent = file_get_contents(filename: $filePath);
            $stream      = \GuzzleHttp\Psr7\Utils::streamFor(resource: $fileContent);
            $response    = $this->getResponse()->withBody(body: $stream);
            $response    = $response
                ->withAddedHeader(name: 'Content-Type', value: \mime_content_type(filename: $filePath))
                ->withAddedHeader(name: 'Content-Transfer-Encoding', value: 'binary')
                ->withAddedHeader(name: 'Content-Length', value: \filesize(filename: $filePath))
                ->withAddedHeader(name: 'Cache-Control', value: 'proxy-revalidate, must-revalidate, no-cache, no-store')
                ->withAddedHeader(name: 'Pragma', value: 'no-cache')
                ->withAddedHeader(name: 'Content-Disposition', value: 'attachment; filename="' . \basename(path: $requestedFile) . '"')
            ;
            $this->setResponse(response: $response);

            return $this->getResponse();
        } catch (\Exception) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

            return $this->redirect(to: IndexAction::getRoute());
        }
    }
}
