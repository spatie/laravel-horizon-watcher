<?php

namespace Spatie\HorizonWatcher;

use Spatie\HorizonWatcher\Commands\HorizonWatcherCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HorizonWatcherServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-horizon-watcher')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-horizon-watcher_table')
            ->hasCommand(HorizonWatcherCommand::class);
    }
}
