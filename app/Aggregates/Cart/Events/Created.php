<?php

namespace App\Aggregates\Cart\Events;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class Created implements SerializablePayload
{

    public function toPayload(): array
    {
        return [];
    }

    public static function fromPayload(array $payload): SerializablePayload
    {
        return new static();
    }
}
