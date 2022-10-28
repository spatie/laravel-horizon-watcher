<?php

use Spatie\HorizonWatcher\Commands\WatchHorizonCommand;

it('will fail in test environment', function () {
    $this->artisan(WatchHorizonCommand::class)->assertFailed();
});
