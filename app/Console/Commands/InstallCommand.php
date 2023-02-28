<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'shop:install';
    protected $description = 'Install laravel shop';

    public function handle(): int
    {
        return self::SUCCESS;
    }
}
