<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:ensure-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure the storage symbolic link exists';

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
        if (!file_exists(public_path('storage'))) {
            $this->info('Creating storage link...');
            Artisan::call('storage:link');
            $this->info('Storage link created successfully!');
        } else {
            $this->info('Storage link already exists!');
        }

        return 0;
    }
}