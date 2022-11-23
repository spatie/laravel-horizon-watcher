<?php

namespace Spatie\HorizonWatcher\Commands;

use Illuminate\Console\Command;
use Spatie\Watcher\Watch;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Process\Process;

class WatchQueueWorkCommand extends Command
{
    protected Process $queueWorkProcess;

    protected $signature = 'queue:watch {--queue=default}';

    protected $description = 'Run Queue and restart it when PHP files are changed';

    public function handle()
    {
        $this->components->info('Starting Queue ' . $this->option('queue') . ' and will restart it when any files change...');

        $queueWorkStarted = $this->startQueueWork();

        if (! $queueWorkStarted) {
            return CommandAlias::FAILURE;
        }

        $this->listenForChanges();
    }

    protected function startQueueWork(): bool
    {
        $this->queueWorkProcess = Process::fromShellCommandline(config('queue-watcher.command') .'--queue=' . $this->option('queue'));

        $this->queueWorkProcess->setTty(true)->setTimeout(null);

        $this->queueWorkProcess->start(fn ($type, $output) => $this->info($output));

        sleep(1);

        return ! $this->queueWorkProcess->isTerminated();
    }

    protected function listenForChanges(): self {
        Watch::paths(config('queue-watcher.paths'))
            ->onAnyChange(function (string $event, string $path) {
                if ($this->changedPathShouldRestartQueue($path)) {
                    $this->restartQueue();
                }
            })
            ->start();

        return $this;
    }

    protected function changedPathShouldRestartQueue(string $path): bool
    {
        if($this->isPhpFile($path)) {
            return true;
        }

        foreach (config('queue-watcher.paths') as $configuredPath) {
            if($path === $configuredPath) {
                return true;
            }
        }

        return false;
    }

    protected function restartQueue(): self
    {
        $this->components->info('Change detected! Restarting Queue . ' . $this->option('queue') . '...');

        $this->queueWorkProcess->stop();

        $this->startQueueWork();

        return $this;
    }

    protected function isPhpFile(string $path): bool
    {
        return str_ends_with(strtolower($path), '.php');
    }
}