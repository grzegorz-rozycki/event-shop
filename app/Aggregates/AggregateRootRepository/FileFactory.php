<?php

namespace App\Aggregates\AggregateRootRepository;

use App\Aggregates\MessageRepository\File;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use Illuminate\Support\Str;

class FileFactory implements Factory
{
    public static function make(string $aggregateRootClassName): AggregateRootRepository
    {
        $storageDir = storage_path(join(DIRECTORY_SEPARATOR, ['app', 'aggregates', $aggregateRootClassName::NAME]));

        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        $serializer = new ConstructingMessageSerializer();
        $messageRepository = new File($storageDir, $serializer);

        return new ConstructingAggregateRootRepository($aggregateRootClassName, $messageRepository);
    }
}
