<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LaravelToolkitCommand extends Command
{
    public $signature = 'laravel-toolkit:require-packages';

    public $description = 'Use Composer to interactively install commonly used packages ';

    public function handle(): int
    {
//        $require = [
//            'datacreativa/laravel-presentable',
//            'doctrine/dbal',
//        ];
//
//        if ($this->confirm('Install astrotomic/laravel-cachable-attributes?')) {
//            $require[] = 'astrotomic/laravel-cachable-attributes';
//        }
//
//        if ($this->confirm('Install blade-ui-kit/blade-icons?')) {
//            $require[] = 'blade-ui-kit/blade-icons';
//
//            if ($this->confirm('Install blade-ui-kit/blade-zondicons?')) {
//                $require[] = 'blade-ui-kit/blade-zondicons';
//            }
//        }
//
//
//        if ($this->confirm('Install livewire/livewire?')) {
//            $require[] = 'livewire/livewire';
//
//            if ($this->confirm('Install wire-elements/modal?')) {
//                $require[] = 'wire-elements/modal';
//            }
//
//            if ($this->confirm('Install wire-elements/spotlight?')) {
//                $require[] = 'wire-elements/spotlight';
//            }
//        }
//
//        if ($this->confirm('Install laravel/socialite?')) {
//            $require[] = 'laravel/socialite';
//        }
//
//        if ($this->confirm('Install ticketevolution/ticketevolution-php?')) {
//            $require[] = 'ticketevolution/ticketevolution-php';
//        }
//
//        if ($this->confirm('Install milon/barcode?')) {
//            $require[] = 'milon/barcode';
//        }
//
//        $string = 'composer require '.implode(' ', $require);
//        $this->info('Running: '.$string);
//
//        app()->make(Composer::class)->run(['require', implode(' ', $require)]);
//
//
//
//
//        if ($this->confirm('Install barryvdh/laravel-debugbar?')) {
//            $requireDev[] = 'barryvdh/laravel-debugbar';
//        }

        if ($this->confirm('Install barryvdh/laravel-ide-helper?')) {
            $requireDev[] = 'barryvdh/laravel-ide-helper';

            $composerJson = File::get(base_path('composer.json'));
            $composerFile = json_decode($composerJson);
            dump($composerFile);

            if (! in_array('@php artisan ide-helper:generate', $composerFile['scripts']['post-autoload-dump'], true)) {
            }
        }


        $string = 'composer require --dev '.implode(' ', $requireDev);
        $this->info('Running: '.$string);

        app()->make(Composer::class)->run(['require --dev', implode(' ', $requireDev)]);

        $this->comment('All done');

        return self::SUCCESS;
    }
}
//"scripts": {
//    "post-autoload-dump": [
//        "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
//        "@php artisan ide-helper:generate",
//        "@php artisan ide-helper:meta",
//        "@php artisan ide-helper:models -M",
//        "@php artisan package:discover --ansi",
//        "@php artisan vendor:publish --force --tag=livewire:assets --ansi"
//    ],
