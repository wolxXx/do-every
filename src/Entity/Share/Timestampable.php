<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Share;

trait Timestampable
{
    protected function onCreateTS($model): static
    {
        if (true === method_exists($model, 'setCreatedAt')) {
            $model->setCreatedAt(\Carbon\Carbon::now());
        }

        return $this;
    }

    protected function onUpdateTS($model): static
    {
        if (true === method_exists($model, 'setUpdatedAt')) {
            $model->setUpdatedAt(\Carbon\Carbon::now());
        }

        return $this;
    }
}
