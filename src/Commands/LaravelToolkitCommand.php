<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class LaravelToolkitCommand extends Command
{
    public $signature = 'laravel-toolkit:run-commands';

    public $description = 'Run commands';

    public function handle(): int
    {
        Artisan::call('laravel-toolkit:disable-lazy-loading');
        Artisan::call('laravel-toolkit:require-packages');

        return self::SUCCESS;
    }
}
