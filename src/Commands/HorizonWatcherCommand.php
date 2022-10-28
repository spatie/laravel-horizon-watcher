<?php

namespace Spatie\HorizonWatcher\Commands;

use Illuminate\Console\Command;

class HorizonWatcherCommand extends Command
{
    public $signature = 'laravel-horizon-watcher';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
