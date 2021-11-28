<?php

namespace JWCobb\LaravelToolkit\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use JWCobb\LaravelToolkit\LaravelToolkitServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'JWCobb\\LaravelToolkit\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelToolkitServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-toolkit_table.php.stub';
        $migration->up();
        */
    }
}
