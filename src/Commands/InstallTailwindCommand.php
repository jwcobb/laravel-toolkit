<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
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
            $this->addPostCSSPlugin();
            $this->configureTemplatePaths();
            $this->addTailwindDirectives();
            if ($this->confirm('Extend the default Tailwind theme colors with primary and secondary colors?')) {
                $this->extendThemeColors();
            } else {
            }

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

    private function addPostCSSPlugin(): void
    {
        $path = 'webpack.mix.js';
        if (! Str::contains(
            $file = file_get_contents(base_path($path)),
            'tailwindcss'
        )) {
            file_put_contents(base_path($path), str_replace(
                ".postCss('resources/css/app.css', 'public/css', [".PHP_EOL."        //".PHP_EOL."    ])",
                ".postCss('resources/css/app.css', 'public/css', [".PHP_EOL."        require(\"tailwindcss\"),".PHP_EOL."    ])",
                $file
            ));
        }
        $this->info("Tailwind has been added as a PostCSS plugin in {$path}.");
    }

    private function configureTemplatePaths(): void
    {
        $path = 'tailwind.config.js';
        if (Str::contains(
            $file = file_get_contents(base_path($path)),
            'content: [],'
        )) {
            file_put_contents(base_path($path), str_replace(
                'content: [],',
                'content: ["./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue",],',
                $file
            ));
        }
        $this->info("Tailwind template paths have been configured in {$path}.");
    }

    private function addTailwindDirectives(): void
    {
        $path = 'resources/css/app.css';
        if (! Str::contains(
            $file = file_get_contents(base_path($path)),
            '@tailwind base'
        )) {
            file_put_contents(
                base_path($path),
                '@tailwind base;'.PHP_EOL.'@tailwind components;'.PHP_EOL.'@tailwind utilities;'.$file
            );
        }
        $this->info("Tailwind directives have been added to {$path}.");
    }

    private function extendThemeColors(): void
    {
        $colors = <<<END
        extend: {
            colors: {
                'primary': {
                    // https://www.tailwindshades.com/#color=111.54929577464789%2C91.41630901287556%2C54.313725490196084&step-up=8&step-down=11&hue-shift=0&name=harlequin&overrides=e30%3D
                    DEFAULT: '#3EF520',
                    '50': '#D6FDD0',
                    '100': '#C5FCBC',
                    '200': '#A3FA95',
                    '300': '#82F96E',
                    '400': '#60F747',
                    '500': '#3EF520',
                    '600': '#26D309',
                    '700': '#1C9E07',
                    '800': '#136805',
                    '900': '#093202'
                },
                'secondary': {
                    // Rich Black from https://coolors.co/3ef520-141115-4c2b36-8d6346-9d75cb
                    // https://www.tailwindshades.com/#color=285%2C10.526315789473683%2C7.450980392156863&step-up=8&step-down=11&hue-shift=0&name=baltic-sea&overrides=e30%3D
                    DEFAULT: '#141115',
                    '50': '#75637A',
                    '100': '#6A5A6F',
                    '200': '#544859',
                    '300': '#3F3642',
                    '400': '#29232C',
                    '500': '#141115',
                    '600': '#000000',
                    '700': '#000000',
                    '800': '#000000',
                    '900': '#000000'
                },
            },
        }
END;

        $path = 'tailwind.config.js';
        if (Str::contains(
            $file = file_get_contents(base_path($path)),
            'extend: {}'
        )) {
            file_put_contents(base_path($path), str_replace(
                'extend: {}',
                $colors,
                $file
            ));
        }
        $this->info("Tailwind theme colors have been extended in {$path}.");
    }
}
