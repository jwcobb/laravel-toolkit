<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DisableLazyLoadingCommand extends Command
{

    public $signature = 'laravel-toolkit:disable-lazy-loading';

    public $description = 'Disable lazy-loading in non-Production environments.';


    public function handle(): int
    {
        if ($this->confirm('Disable lazy-loading in non-Production environments?')) {
            if (! Str::contains($appSP = file_get_contents(base_path('app/Providers/AppServiceProvider.php')),
                "Model::preventLazyLoading")) {
                file_put_contents(base_path('app/Providers/AppServiceProvider.php'), str_replace(
                    "public function boot()".PHP_EOL."{",
                    "public function boot()".PHP_EOL."{".PHP_EOL."    Model::preventLazyLoading(! app()->isProduction());".PHP_EOL,
                    $appSP
                ));
            }

            $this->info('Lazy loading will be prevented in non-Production environments.');
            $this->comment('All done');
        }

        return self::SUCCESS;
    }
}
