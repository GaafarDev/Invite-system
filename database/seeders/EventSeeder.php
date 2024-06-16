<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            [
                'title' => 'Sample Event 1',
                'description' => 'This is a sample event 1',
                'time' => Carbon::create('2024', '07', '01', '10', '00', '00'),
                'location' => 'Sample Location 1',
                'capacity' => 100,
                'organizer_contact' => 'contact1@example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Sample Event 2',
                'description' => 'This is a sample event 2',
                'time' => Carbon::create('2024', '07', '02', '11', '00', '00'),
                'location' => 'Sample Location 2',
                'capacity' => 200,
                'organizer_contact' => 'contact2@example.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
