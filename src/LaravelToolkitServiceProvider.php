<?php

namespace JWCobb\LaravelToolkit;

use JWCobb\LaravelToolkit\Commands\LaravelToolkitCommand;
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
            ->hasMigration('create_street_addresses_table')
            ->hasCommand(LaravelToolkitCommand::class)
            ->hasCommand(DisableLazyLoadingCommand::class)
            ->hasCommand(RequirePackagesCommand::class)
        ;
    }
}
