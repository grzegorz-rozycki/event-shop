<?php

namespace App\Providers;

use App\Aggregates\AggregateRootRepository;
use Illuminate\Support\ServiceProvider;

class AggregateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AggregateRootRepository\Factory::class, AggregateRootRepository\FileFactory::class);

    }

    public function boot()
    {
    }
}
