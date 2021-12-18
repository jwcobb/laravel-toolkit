<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;

class LaravelToolkitCommand extends Command
{
    public $signature = 'laravel-toolkit:run-commands';

    public $description = 'Run commands';

    public function handle(): int
    {
        $this->call('laravel-toolkit:disable-lazy-loading');
        $this->call('laravel-toolkit:require-packages');
        $this->call('laravel-toolkit:install-tailwind');

        return self::SUCCESS;
    }
}
