<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestDatabaseConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:test-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the database connection';

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
        $this->info('Testing database connection...');
        
        try {
            DB::connection()->getPdo();
            $this->info('Database connection successful!');
            $this->info('Connected to database: ' . DB::connection()->getDatabaseName());
            
            // Check if tables exist
            $tables = DB::select('SHOW TABLES');
            $this->info('Database tables:');
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                $this->info('- ' . $tableName);
                
                // Count records in each table
                $count = DB::table($tableName)->count();
                $this->info('  Records: ' . $count);
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Database connection failed!');
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}