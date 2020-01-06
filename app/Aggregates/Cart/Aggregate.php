<?php

namespace App\Aggregates\Cart;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use LogicException;

class Aggregate implements AggregateRoot
{
    use AggregateRootBehaviour;

    public const NAME = 'cart';

    protected $exists = false;

    protected $items = [];

    public function __construct(Id $id)
    {
        $this->aggregateRootId = $id;
    }

    public function exists(): bool
    {
        return $this->exists;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function performCreated()
    {
        $this->recordThat(new Events\Created());
    }

    public function performItemAdded(array $payload)
    {
        if (isset($this->items[$payload['id'] ?? 0]))
            throw new LogicException(__('aggregate.cart.item_already_exists'));

        $this->recordThat(new Events\ItemAdded($payload));
    }

    protected function applyCreated()
    {
        $this->exists = true;
    }

    protected function applyItemAdded(Events\ItemAdded $event)
    {
        $this->items[$event->getId()] = $event->toPayload();
    }
}
