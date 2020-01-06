<?php

namespace App\Aggregates\AggregateRootRepository;

use App\Aggregates\MessageRepository\Database;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use Illuminate\Support\Str;

class DatabaseFactory implements Factory
{
    public static function make(string $aggregateRootClassName): AggregateRootRepository
    {
        $table = 'aggregate_' . $aggregateRootClassName::NAME;
        $serializer = new ConstructingMessageSerializer();
        $messageRepository = new Database($serializer, $table);

        return new ConstructingAggregateRootRepository($aggregateRootClassName, $messageRepository);
    }
}
