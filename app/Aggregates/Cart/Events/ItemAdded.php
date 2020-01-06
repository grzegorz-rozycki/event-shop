<?php

namespace App\Aggregates\Cart\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ItemAdded implements SerializablePayload
{
    protected $amount;

    protected $id;

    public function __construct(array $payload = [])
    {
        [
            'amount' => $this->amount,
            'id' => $this->id,
        ] = $payload;
    }

    public function toPayload(): array
    {
        return ['amount' => $this->amount, 'id' => $this->id];
    }

    public static function fromPayload(array $payload): SerializablePayload
    {
        return new static($payload);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}
