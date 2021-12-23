<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallTailwindCommand extends Command
{
    public $signature = 'laravel-toolkit:install-tailwind';

    public $description = 'Install TailwindCSS.';

    public function handle(): int
    {
        if ($this->confirm('Install TailwindCSS?')) {
            // https://tailwindcss.com/docs/guides/laravel
            $this->installTailwind();
            $this->initializeTailwind();
            $this->replaceWebpackMixJs();
            $this->replaceTailwindConfigJs();
            $this->replaceAppCss();

            $this->comment('All done');
        }

        return self::SUCCESS;
    }

    private function installTailwind(): void
    {
        $process = new Process(['npm', 'install', '-D', 'tailwindcss', 'postcss', 'autoprefixer']);
        $process->run();
        $this->info('Tailwind has been installed.');
    }

    private function initializeTailwind(): void
    {
        $process = new Process(['npx', 'tailwindcss', 'init']);
        $process->run();
        $this->info('Tailwind has been initialized.');
    }

    private function replaceWebpackMixJs(): void
    {
        $originalPath = 'https://raw.githubusercontent.com/laravel/laravel/8.x/webpack.mix.js';
        $stubPath = 'vendor/jwcobb/laravel-toolkit/stubs/webpack.mix.js.stub';
        $path = 'webpack.mix.js';

        if (file_get_contents(base_path($path)) === file_get_contents($originalPath)) {
            $replaceFile = true;
        } else {
            $replaceFile = $this->confirm("{$path} has been altered from the original. Are you sure you want to overwrite it?", false);
        }

        if ($replaceFile) {
            copy(base_path($stubPath), (base_path($path)));
            $this->info("Your default file has been placed at {$path}.");
        } else {
            $this->info("Don’t forget to manually add Tailwind as a PostCSS plugin in {$path}.");
            $this->comment("Docs: https://tailwindcss.com/docs/guides/laravel");
        }
    }

    private function replaceTailwindConfigJs(): void
    {
        $originalPath = 'https://raw.githubusercontent.com/tailwindlabs/tailwindcss/master/stubs/simpleConfig.stub.js';
        $stubPath = 'vendor/jwcobb/laravel-toolkit/stubs/tailwind.config.js.stub';
        $path = 'tailwind.config.js';

        if (file_get_contents(base_path($path)) === file_get_contents($originalPath)) {
            $replaceFile = true;
        } else {
            $replaceFile = $this->confirm("{$path} has been altered from the original. Are you sure you want to overwrite it?", false);
        }

        if ($replaceFile) {
            copy(base_path($stubPath), (base_path($path)));
            $this->info("Your default file has been placed at {$path}.");
        } else {
            $this->info("Don’t forget to manually configure your template paths in {$path}.");
            $this->comment("Docs: https://tailwindcss.com/docs/guides/laravel");
        }
    }

    private function replaceAppCss(): void
    {
        $originalPath = 'https://raw.githubusercontent.com/laravel/laravel/8.x/resources/css/app.css';
        $stubPath = 'vendor/jwcobb/laravel-toolkit/stubs/app.css.stub';
        $path = 'resources/css/app.css';

        if (file_get_contents(base_path($path)) === file_get_contents($originalPath)) {
            $replaceFile = true;
        } else {
            $replaceFile = $this->confirm("{$path} has been altered from the original. Are you sure you want to overwrite it?", false);
        }

        if ($replaceFile) {
            copy(base_path($stubPath), (base_path($path)));
            $this->info("Your default file has been placed at {$path}.");
        } else {
            $this->info("Don’t forget to add the Tailwind directives to your CSS in {$path}.");
            $this->comment("Docs: https://tailwindcss.com/docs/guides/laravel");
        }
    }
}
