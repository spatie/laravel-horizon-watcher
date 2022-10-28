<?php

namespace Spatie\HorizonWatcher\Tests;

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
