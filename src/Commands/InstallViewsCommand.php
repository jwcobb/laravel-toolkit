<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;

class InstallViewsCommand extends Command
{
    public $signature = 'laravel-toolkit:install-views';

    public $description = 'Install some default views.';

    public function handle(): int
    {
        if ($this->confirm('Install some default views?', true)) {
            $files = [
                'resources/views/layouts/app.blade.php' => 'vendor/jwcobb/laravel-toolkit/stubs/views/app.blade.php.stub',
                'resources/views/partisals/google-analytics.blade.php' => 'vendor/jwcobb/laravel-toolkit/stubs/views/google-analytics.blade.php.stub',
            ];

            foreach ($files as $destination => $stub) {
                if (file_exists(base_path($destination))) {
                    $this->warn("SKIPPED: A file already exists at {$destination}.");
                } else {
                    copy(base_path($stub), base_path($destination));
                    $this->info("INSTALLED: {$destination}.");
                }
            }
        }

        return self::SUCCESS;
    }
}
