<?php

namespace JWCobb\LaravelToolkit;

use JWCobb\LaravelToolkit\Commands\InstallPackagesCommand;
use JWCobb\LaravelToolkit\Commands\InstallSEOServiceProviderCommand;
use JWCobb\LaravelToolkit\Commands\InstallTailwindCommand;
use JWCobb\LaravelToolkit\Commands\InstallViewsCommand;
use JWCobb\LaravelToolkit\Commands\LaravelToolkitInstallerCommand;
use JWCobb\LaravelToolkit\Commands\PreventLazyLoadingCommand;
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
            ->hasMigration('create_addresses_table')
            ->hasMigration('create_email_addresses_table')
            ->hasMigration('create_phone_numbers_table')
            ->hasCommand(LaravelToolkitInstallerCommand::class)
            ->hasCommand(InstallPackagesCommand::class)
            ->hasCommand(InstallSEOServiceProviderCommand::class)
            ->hasCommand(InstallTailwindCommand::class)
            ->hasCommand(InstallViewsCommand::class)
            ->hasCommand(PreventLazyLoadingCommand::class);
    }

}
