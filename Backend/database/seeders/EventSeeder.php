<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        Event::create([
            'category' => 'Educational & Business',
            'title' => 'Tech Conference 2024',
            'description' => 'A conference about the latest in technology.',
            'location' => 'San Francisco, CA',
            'start_datetime' => '2024-07-01 09:00:00',
            'end_datetime' => '2024-07-01 17:00:00',
            'image_link' => 'https://example.com/image1.jpg',
            'user_id' => 1,
        ]);

        Event::create([
            'category' => 'Educational & Business',
            'title' => 'Laravel Workshop',
            'description' => 'A workshop on building web applications with Laravel.',
            'location' => 'Los Angeles, CA',
            'start_datetime' => '2024-07-10 10:00:00',
            'end_datetime' => '2024-07-10 16:00:00',
            'image_link' => 'https://example.com/image2.jpg',
            'user_id' => 1,
        ]);

        Event::create([
            'category' => 'Technology & Innovation',
            'title' => 'AI in 2024',
            'description' => 'A webinar discussing the advancements in AI.',
            'location' => 'Online',
            'start_datetime' => '2024-07-15 14:00:00',
            'end_datetime' => '2024-07-15 15:00:00',
            'image_link' => 'https://example.com/image3.jpg',
            'user_id' => 1,
        ]);

        Event::create([
            'category' => 'Travel & Adventure',
            'title' => 'Developer Meetup',
            'description' => 'A meetup for developers to network and share ideas.',
            'location' => 'New York, NY',
            'start_datetime' => '2024-07-20 18:00:00',
            'end_datetime' => '2024-07-20 20:00:00',
            'image_link' => 'https://example.com/image4.jpg',
            'user_id' => 1,
        ]);
    }
}

