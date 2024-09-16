<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Share;

trait Task
{
    public function getTask(string $argumentName = 'id'): \Psr\Http\Message\ResponseInterface|\DoEveryApp\Entity\Task
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe($argumentName));
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger($this->translator->taskNotFound());

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        return $task;
    }
}
