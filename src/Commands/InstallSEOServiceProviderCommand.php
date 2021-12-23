<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallSEOServiceProviderCommand extends Command
{
    public $signature = 'laravel-toolkit:install-seo-service-provider';

    public $description = 'Install a ServiceProvider with defaults for archtechx/laravel-seo.';

    public function handle(): int
    {
        if ($this->confirm('Install the SEOServiceProvider?', true)) {
            $stubPath = 'vendor/jwcobb/laravel-toolkit/stubs/SEOServiceProvider.php.stub';
            $path = 'app/Providers/SEOServiceProvider.php';

            if (! file_exists(base_path($path))) {
                $replaceFile = true;
            } else {
                $replaceFile = $this->confirm("{$path} already exists. Are you sure you want to overwrite it?", false);
            }

            if ($replaceFile) {
                copy(base_path($stubPath), (base_path($path)));

                $this->activateServiceProvider();

                $this->info("SEO defaults will be set via a ServiceProvider at {$path}.");
            } else {
                $this->info("Be sure to handle defaults for SEO.");
            }
        }

        return self::SUCCESS;
    }


    private function activateServiceProvider()
    {
        $path = 'config/app.php';

        if (! Str::contains(
            $file = file_get_contents(base_path($path)),
            "SEOServiceProvider"
        )) {
            file_put_contents(base_path($path), str_replace(
                'App\Providers\RouteServiceProvider::class,',
                'App\Providers\RouteServiceProvider::class,'
                .PHP_EOL
                .'App\Providers\SEOServiceProvider::class,',
                $file
            ));
        }
    }
}
