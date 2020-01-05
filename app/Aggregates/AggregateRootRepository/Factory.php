<?php

namespace App\Aggregates\AggregateRootRepository;

use EventSauce\EventSourcing\AggregateRootRepository;

interface Factory
{
    public static function make(string $aggregateRootClassName): AggregateRootRepository;
}
