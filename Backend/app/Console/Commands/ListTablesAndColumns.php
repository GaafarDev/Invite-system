<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListTablesAndColumns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-tables-and-columns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = \DB::select("SELECT name FROM sqlite_master WHERE type='table'");
    
        foreach ($tables as $table) {
            $tableName = $table->name;
            $this->line("Table: $tableName");
    
            $columns = \DB::getSchemaBuilder()->getColumnListing($tableName);
    
            foreach ($columns as $column) {
                $this->line("Column: $column");
            }
    
            $this->line("");
        }
    }
}
