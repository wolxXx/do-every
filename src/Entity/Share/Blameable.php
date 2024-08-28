<?php

namespace DoEveryApp\Entity\Share;

trait Blameable
{
    protected function onCreate($model): static
    {
        if (true === method_exists($model, 'setCreatedBy')) {
            $model->setCreatedBy($this->getUser());
        }

        return $this;
    }


    private function getUser(): string
    {
        $user = \DoEveryApp\Util\User\Current::get();
        if (null === $user) {
            return 'anonymous';
        }

        return $user->getName();
    }


    protected function onUpdate($model): static
    {
        if (true === method_exists($model, 'setUpdatedBy')) {
            $model->setUpdatedBy($this->getUser());
        }

        return $this;
    }
}