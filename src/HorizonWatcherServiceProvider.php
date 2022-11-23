<?php

namespace Spatie\HorizonWatcher;

use Spatie\HorizonWatcher\Commands\WatchHorizonCommand;
use Spatie\HorizonWatcher\Commands\WatchQueueWorkCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HorizonWatcherServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-horizon-watcher')
            ->hasConfigFile()
            ->hasCommand(WatchHorizonCommand::class)
            ->hasCommand(WatchQueueWorkCommand::class);
    }
}
