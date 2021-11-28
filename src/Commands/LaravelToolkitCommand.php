<?php

namespace JWCobb\LaravelToolkit\Commands;

use Illuminate\Console\Command;

class LaravelToolkitCommand extends Command
{
    public $signature = 'laravel-toolkit';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
