<?php

namespace App\Aggregates\Cart;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

class Aggregate implements AggregateRoot
{
    use AggregateRootBehaviour;

    public function __construct(Id $id)
    {
        $this->aggregateRootId = $id;
    }
}
