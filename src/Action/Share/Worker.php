<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Share;

trait Worker
{
    public function getWorker(string $argumentName = 'id'): \Psr\Http\Message\ResponseInterface|\DoEveryApp\Entity\Worker
    {
        $worker = \DoEveryApp\Entity\Worker::getRepository()->find($this->getArgumentSafe($argumentName));
        if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
            \DoEveryApp\Util\FlashMessenger::addDanger($this->translator->workerNotFound());

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        return $worker;
    }
}
