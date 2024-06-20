<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsFromEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $columnsToDrop = [   "title",
            "description",
            "time",
            "location",
            "capacity",
            "organizer_contact",
            "created_at",
            "updated_at",
            // "category",
        ]; // replace with your column names
            $table->dropColumn($columnsToDrop);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Here you should add the columns back in case you need to rollback the migration
        });
    }
}