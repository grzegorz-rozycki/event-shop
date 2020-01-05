<?php

namespace App\Aggregates\MessageRepository;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Generator;

class File implements MessageRepository
{
    /** @var string $directory */
    private $directory;
    /** @var MessageSerializer $serializer */
    private $serializer;

    public function __construct(string $directory, MessageSerializer $serializer)
    {
        $this->directory = $directory;
        $this->serializer = $serializer;
    }

    public function persist(Message ...$messages)
    {
        if (empty($messages))
            return;
        $rootId = $messages[0]->aggregateRootId();
        file_put_contents($this->fileForAggregate($rootId), json_encode(array_map([$this->serializer, 'serializeMessage'], $messages)));
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        return $this->retrieveAllAfterVersion($id, 0);
    }

    public function retrieveAllAfterVersion(AggregateRootId $id, int $aggregateRootVersion): Generator
    {
        $file = $this->fileForAggregate($id);

        if (!is_file($file))
            return 0;

        $messages = json_decode(file_get_contents($file), true);
        /** @var array $payload */
        foreach ($messages as $payload) {
            /** @var Message $message */
            foreach ($this->serializer->unserializePayload($payload) as $message) {
                if ($message->aggregateVersion() > $aggregateRootVersion) {
                    yield $message;
                }
            }
        }

        return isset($message) ? $message->aggregateVersion() : 0;
    }

    public function fileForAggregate(AggregateRootId $id): string
    {
        return "{$this->directory}/{$id->toString()}.json";
    }
}
