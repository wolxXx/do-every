<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron\Notification;

class Container
{
    /**
     * @var \DoEveryApp\Util\Cron\Notification\Item\ItemInterface[]
     */
    protected array $items = [];
    public function __construct(
        public readonly \DoEveryApp\Entity\Worker $worker,
    ) {

    }

    public function addItem(Item\ItemInterface $item): static
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param \DoEveryApp\Util\Cron\Notification\Item\ItemInterface[] $items
     */
    public function addItems(array $items): static
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @return \DoEveryApp\Util\Cron\Notification\Item\ItemInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function itemCount(): int
    {
        return count($this->items);
    }
}