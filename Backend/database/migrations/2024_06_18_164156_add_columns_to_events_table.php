<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('category');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('image_link')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'title',
                'description',
                'location',
                'start_datetime',
                'end_datetime',
                'image_link',
                'user_id',
            ]);
        });
    }
};
