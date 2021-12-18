<?php

namespace JWCobb\LaravelToolkit;

use JWCobb\LaravelToolkit\Commands\DisableLazyLoadingCommand;
use JWCobb\LaravelToolkit\Commands\InstallTailwindCommand;
use JWCobb\LaravelToolkit\Commands\LaravelToolkitCommand;
use JWCobb\LaravelToolkit\Commands\RequirePackagesCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelToolkitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-toolkit')
            ->hasConfigFile('site')
//            ->hasViews()
            ->hasMigration('create_email_addresses_table')
            ->hasMigration('create_phone_numbers_table')
            ->hasMigration('create_addresses_table')
            ->hasCommand(LaravelToolkitCommand::class)
            ->hasCommand(DisableLazyLoadingCommand::class)
            ->hasCommand(RequirePackagesCommand::class)
            ->hasCommand(InstallTailwindCommand::class)
        ;
    }
}
