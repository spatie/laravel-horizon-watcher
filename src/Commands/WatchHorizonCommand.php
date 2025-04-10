<?php

namespace Spatie\HorizonWatcher\Commands;

use Dotenv\Dotenv;
use Illuminate\Console\Command;
use Spatie\Watcher\Watch;
use Symfony\Component\Process\Process;

class WatchHorizonCommand extends Command
{
    protected Process $horizonProcess;

    protected $signature = 'horizon:watch {--without-tty : Disable output to TTY} {--reload-config : Reload configuration every time a file changes}';

    protected $description = 'Run Horizon and restart it when PHP files are changed';

    protected $trappedSignal = null;

    public function handle()
    {
        $this->components->info('Starting Horizon, and restart when any file changes...');

        if (! $this->startHorizon()) {
            return Command::FAILURE;
        }

        $this->listenForChanges();
    }

    protected function startHorizon(): bool
    {
        $environment = $this->option('reload-config')
            ? Dotenv::createArrayBacked(base_path())->load()
            : null;

        $this->horizonProcess = Process::fromShellCommandline(config('horizon-watcher.command'), null, $environment)
            ->setTty(! $this->option('without-tty'))
            ->setTimeout(null);

        $this->trap([SIGINT, SIGTERM, SIGQUIT], function ($signal): void {
            $this->trappedSignal = $signal;

            // Forward signal to Horizon process.
            $this->horizonProcess->stop(signal: $signal);
            $this->horizonProcess->wait();
        });

        $this->horizonProcess->start(fn ($type, $output) => $this->info($output));

        sleep(1);

        return ! $this->horizonProcess->isTerminated();
    }

    protected function listenForChanges(): self
    {
        Watch::paths(config('horizon-watcher.paths'))
            ->onAnyChange(function (string $event, string $path) {
                if ($this->changedPathShouldRestartHorizon($path)) {
                    $this->restartHorizon();
                }
            })
            ->shouldContinue(function () {
                return $this->trappedSignal === null;
            })
            ->start();

        return $this;
    }

    protected function changedPathShouldRestartHorizon(string $path): bool
    {
        if ($this->isPhpFile($path)) {
            return true;
        }

        foreach (config('horizon-watcher.paths') as $configuredPath) {
            if ($path === $configuredPath) {
                return true;
            }
        }

        return false;
    }

    protected function restartHorizon(): self
    {
        $this->components->info('Change detected! Restarting horizon...');

        $this->horizonProcess->stop();
        $this->horizonProcess->wait();

        $this->startHorizon();

        return $this;
    }

    protected function isPhpFile(string $path): bool
    {
        return str_ends_with(strtolower($path), '.php');
    }
}
