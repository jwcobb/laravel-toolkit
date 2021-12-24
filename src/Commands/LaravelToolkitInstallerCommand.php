<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;

class LaravelToolkitInstallerCommand extends Command
{
    public $signature = 'laravel-toolkit:install';

    public $description = 'Run commands';

    public function handle(): int
    {
        $this->call('laravel-toolkit:prevent-lazy-loading');
        $this->call('laravel-toolkit:install-packages');
        $this->call('laravel-toolkit:install-tailwind');
        $this->call('laravel-toolkit:install-seo-service-provider');
        $this->call('laravel-toolkit:install-views');

        return self::SUCCESS;
    }
}
