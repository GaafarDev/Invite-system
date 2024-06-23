<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckDatabasePath extends Command
{
    protected $signature = 'db:check-path';
    protected $description = 'Check the database path configuration';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $databasePath = config('database.connections.sqlite.database');
        $this->info("SQLite Database Path: " . $databasePath);
        if (file_exists($databasePath)) {
            $this->info("Database file exists.");
        } else {
            $this->error("Database file does not exist.");
        }
    }
}
