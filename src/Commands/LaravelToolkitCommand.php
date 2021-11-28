<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LaravelToolkitCommand extends Command
{
    private array $require = [
        'require',
        'datacreativa/laravel-presentable',
        'doctrine/dbal',
    ];
    private array $requireDev = [
        'require',
        '--dev',
    ];
    private bool $publishLivewireAssets = false;
    private const PUBLISH_LIVEWIRE_ASSETS_SCRIPT = '@php artisan vendor:publish --force --tag=livewire:assets --ansi';
    private const IDE_HELPER_SCRIPTS = [
        '@php artisan ide-helper:generate',
        '@php artisan ide-helper:meta',
        '@php artisan ide-helper:models -M',
    ];

    public $signature = 'laravel-toolkit:require-packages';

    public $description = 'Use Composer to interactively install commonly used packages ';

    public function handle(): int
    {
        if ($this->confirm('Install astrotomic/laravel-cachable-attributes?')) {
            $this->require[] = 'astrotomic/laravel-cachable-attributes';
        }

        if ($this->confirm('Install blade-ui-kit/blade-icons?')) {
            $this->require[] = 'blade-ui-kit/blade-icons';

            if ($this->confirm('Install blade-ui-kit/blade-zondicons?')) {
                $this->require[] = 'blade-ui-kit/blade-zondicons';
            }
        }


        if ($this->confirm('Install livewire/livewire?')) {
            $this->require[] = 'livewire/livewire';

            if ($this->confirm('Publish Livewire assets during post-autoload-dump?')) {
                $this->publishLivewireAssets = true;
            }

            if ($this->confirm('Install wire-elements/modal?')) {
                $this->require[] = 'wire-elements/modal';
            }

            if ($this->confirm('Install wire-elements/spotlight?')) {
                $this->require[] = 'wire-elements/spotlight';
            }
        }

        if ($this->confirm('Install laravel/socialite?')) {
            $this->require[] = 'laravel/socialite';
        }

        if ($this->confirm('Install ticketevolution/ticketevolution-php?')) {
            $this->require[] = 'ticketevolution/ticketevolution-php';
        }

        if ($this->confirm('Install milon/barcode?')) {
            $this->require[] = 'milon/barcode';
        }

        $this->info('Running: composer '.implode(' ', $this->require));

        app()->make(Composer::class)->run($this->require);


        if ($this->confirm('Install barryvdh/laravel-debugbar?')) {
            $this->requireDev[] = 'barryvdh/laravel-debugbar';
        }

        if ($this->confirm('Install barryvdh/laravel-ide-helper?')) {
            $this->requireDev[] = 'barryvdh/laravel-ide-helper';
        }


        $this->info('Running: composer '.implode(' ', $this->requireDev));

        app()->make(Composer::class)->run($this->requireDev);


        if ($this->publishLivewireAssets || in_array('barryvdh/laravel-ide-helper', $this->requireDev, true)) {
            $composerJson = File::get(base_path('composer.json'));
            $composerFile = json_decode($composerJson, false, 512, JSON_THROW_ON_ERROR);


            if (in_array('barryvdh/laravel-ide-helper', $this->requireDev, true)
                && ! in_array(
                    '@php artisan ide-helper:generate',
                    $composerFile->scripts->{'post-autoload-dump'},
                    true
                )) {
                $this->info('Adding ide-helper scripts to post-autoload-dump');

                array_splice($composerFile->scripts->{'post-autoload-dump'}, 1, 0, self::IDE_HELPER_SCRIPTS);
            }


            if ($this->publishLivewireAssets && ! in_array(
                self::PUBLISH_LIVEWIRE_ASSETS_SCRIPT,
                $composerFile->scripts->{'post-autoload-dump'},
                true
            )) {
                $this->info('Adding script to publish Livewire assets to post-autoload-dump');

                $composerFile->scripts->{'post-autoload-dump'}[] = self::PUBLISH_LIVEWIRE_ASSETS_SCRIPT;
            }
            File::put(
                base_path('composer.json'),
                json_encode($composerFile, JSON_THROW_ON_ERROR + JSON_PRETTY_PRINT)
            );
            $this->info('Updated composer.json written.');
        }

        $this->comment('All done');

        return self::SUCCESS;
    }
}
