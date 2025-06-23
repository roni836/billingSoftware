<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrations:reset-and-run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset and re-run all migrations with seeder';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Resetting database migrations...');
        
        try {
            $this->info('Rolling back migrations...');
            Artisan::call('migrate:reset');
            $this->info('Running migrations...');
            Artisan::call('migrate');
            $this->info('Running seeders...');
            Artisan::call('db:seed');
            
            $this->info('Database reset and migrated successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error resetting migrations: ' . $e->getMessage());
            return 1;
        }
    }
}