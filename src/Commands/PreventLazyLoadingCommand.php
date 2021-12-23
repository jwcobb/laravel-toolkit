<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PreventLazyLoadingCommand extends Command
{
    public $signature = 'laravel-toolkit:prevent-lazy-loading';

    public $description = 'Prevent lazy-loading in non-Production environments.';

    public function handle(): int
    {
        if ($this->confirm('Prevent lazy-loading in non-Production environments?', true)) {
            $stubPath = 'vendor/jwcobb/laravel-toolkit/stubs/PreventLazyLoadingServiceProvider.php.stub';
            $path = 'app/Providers/PreventLazyLoadingServiceProvider.php';

            if (! file_exists(base_path($path))) {
                $replaceFile = true;
            } else {
                $replaceFile = $this->confirm("{$path} already exists. Are you sure you want to overwrite it?", false);
            }

            if ($replaceFile) {
                copy(base_path($stubPath), (base_path($path)));

                $this->activateServiceProvider();

                $this->info("Lazy-loading will be prevented in non-production environments via a ServiceProvider at {$path}.");
            } else {
                $this->info("Lazy-loading will be allowed in all environments.");
            }
        }

        return self::SUCCESS;
    }

    private function activateServiceProvider()
    {
        $path = 'config/app.php';

        if (! Str::contains(
            $file = file_get_contents(base_path($path)),
            "PreventLazyLoadingServiceProvider"
        )) {
            file_put_contents(base_path($path), str_replace(
                'App\Providers\RouteServiceProvider::class,',
                'App\Providers\RouteServiceProvider::class,'
                .PHP_EOL
                .'App\Providers\PreventLazyLoadingServiceProvider::class,',
                $file
            ));
        }
    }
}
