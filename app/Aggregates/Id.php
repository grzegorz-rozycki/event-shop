<?php

namespace App\Aggregates;

use EventSauce\EventSourcing\AggregateRootId;

class Id implements AggregateRootId
{
    protected $id;

    public function __construct($id)
    {
        $this->id = strval($id);
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $aggregateRootId): AggregateRootId
    {
        return new static($aggregateRootId);
    }
}
