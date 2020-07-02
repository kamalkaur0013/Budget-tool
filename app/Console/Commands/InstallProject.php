<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install-project {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        exec('composer install');
        echo "\n";
        echo ".";
        exec('php artisan migrate:fresh --seed');
        echo ".";
        exec('php artisan telescope:publish');
        echo ".";
        exec('php artisan key:generate');
        echo ".";
        exec('npm install');
        echo ".\n";
        exec('git checkout -b ' . $this->argument('name'));
        exec('git checkout ' . $this->argument('name'));
        echo "\nDone\n";
        echo "\nStarting server at http://localhost:8000";
        exec('php artisan serve');
    }
}
