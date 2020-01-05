<?php

namespace App\Aggregates\MessageRepository;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Generator;
use Illuminate\Support\Facades\DB;
use Throwable;

class Database implements MessageRepository
{
    protected $serializer;

    protected $table;

    public function __construct(MessageSerializer $serializer, string $table)
    {
        $this->serializer = $serializer;
        $this->table = $table;
    }

    public function persist(Message ...$messages)
    {
        try {
            DB::beginTransaction();
            foreach ($messages as $message) {
                $arguments = $this->serializer->serializeMessage($message);
                $arguments['aggregate_id'] = $message->aggregateRootId()->toString();
                $arguments['aggregate_version'] = $message->aggregateVersion();
                DB::table($this->table)->insert($arguments);
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        return $this->retrieveAllAfterVersion($id, 0);
    }

    public function retrieveAllAfterVersion(AggregateRootId $id, int $aggregateRootVersion): Generator
    {
        $cursor = DB::table($this->table)
            ->where('aggregate_id', $id->toString())
            ->where('aggregate_version', '>=', $aggregateRootVersion)
            ->cursor();

        foreach ($cursor as $record) {
            dd($record);
            /** @var Message $message */
            foreach ($this->serializer->unserializePayload($record) as $message) {
                yield $message;
            }
        }

        return isset($message) ? $message->aggregateVersion() : 0;
    }
}
