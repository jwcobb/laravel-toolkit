<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallPackagesCommand extends Command
{
    private array $require = [];
    private array $requireDev = [];
    private bool $publishLivewireAssets = false;
    private const PUBLISH_LIVEWIRE_ASSETS_SCRIPT = '@php artisan vendor:publish --force --tag=livewire:assets --ansi';
    private const IDE_HELPER_SCRIPTS = [
        '@php artisan ide-helper:generate',
        '@php artisan ide-helper:meta',
        '@php artisan ide-helper:models -M',
    ];

    public $signature = 'laravel-toolkit:install-packages';

    public $description = 'Use Composer to interactively install commonly used packages ';

    public function handle(): int
    {
        if ($this->confirm('Install datacreativa/laravel-presentable for model presenters?', true)) {
            $this->require[] = 'datacreativa/laravel-presentable';
        }

        if ($this->confirm('Install doctrine/dbal to allow migrations to edit tables?', true)) {
            $this->require[] = 'doctrine/dbal';
        }

        if ($this->confirm('Install astrotomic/laravel-cachable-attributes to allow caching of model attributes?', false)) {
            $this->require[] = 'astrotomic/laravel-cachable-attributes';
        }

        if ($this->confirm('Install blade-ui-kit/blade-icons?', true)) {
            $this->require[] = 'blade-ui-kit/blade-icons';

            if ($this->confirm('Install blade-ui-kit/blade-zondicons?', true)) {
                $this->require[] = 'blade-ui-kit/blade-zondicons';
            }
        }


        if ($this->confirm('Install livewire/livewire?', false)) {
            $this->require[] = 'livewire/livewire';

            if ($this->confirm('Publish Livewire assets during post-autoload-dump?', true)) {
                $this->publishLivewireAssets = true;
            }

            if ($this->confirm('Install wire-elements/modal?', false)) {
                $this->require[] = 'wire-elements/modal';
            }

            if ($this->confirm('Install wire-elements/spotlight?', false)) {
                $this->require[] = 'wire-elements/spotlight';
            }
        }

        if ($this->confirm('Install laravel/socialite?', false)) {
            $this->require[] = 'laravel/socialite';
        }

        if ($this->confirm('Install ticketevolution/ticketevolution-php?', false)) {
            $this->require[] = 'ticketevolution/ticketevolution-php';
        }

        if ($this->confirm('Install milon/barcode?', false)) {
            $this->require[] = 'milon/barcode';
        }

        if (empty($this->require)) {
            $this->info('No packages were selected for installation.');
        } else {
            array_unshift($this->require, 'require');
            $this->info('Running: composer '.implode(' ', $this->require));

            app()->make(Composer::class)->run($this->require);
        }


        if ($this->confirm('Install barryvdh/laravel-debugbar?', true)) {
            $this->requireDev[] = 'barryvdh/laravel-debugbar';
        }

        if ($this->confirm('Install barryvdh/laravel-ide-helper?', true)) {
            $this->requireDev[] = 'barryvdh/laravel-ide-helper';
        }


        if (empty($this->requireDev)) {
            $this->info('No dev packages were selected for installation.');
        } else {
            array_unshift($this->requireDev, 'require', '--dev');
            $this->info('Running: composer '.implode(' ', $this->requireDev));

            app()->make(Composer::class)->run($this->requireDev);
        }


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
            $this->info('Running composer dump-autoload to run the newly added scripts.');

            app()->make(Composer::class)->run(['dump-autoload']);
        }

        $this->comment('All done');

        return self::SUCCESS;
    }
}
