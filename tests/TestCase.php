<?php

namespace Spatie\HorizonWatcher\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\HorizonWatcher\HorizonWatcherServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            HorizonWatcherServiceProvider::class,
        ];
    }
}
