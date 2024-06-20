<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run()
    {
        // Tickets for Event 1
        Ticket::create([
            'event_id' => 1,
            'ticket_name' => 'General Admission',
            'ticket_price' => 50.00,
        ]);

        Ticket::create([
            'event_id' => 1,
            'ticket_name' => 'VIP Admission',
            'ticket_price' => 100.00,
        ]);

        // Tickets for Event 2
        Ticket::create([
            'event_id' => 2,
            'ticket_name' => 'Early Bird',
            'ticket_price' => 30.00,
        ]);

        Ticket::create([
            'event_id' => 2,
            'ticket_name' => 'Standard',
            'ticket_price' => 50.00,
        ]);

        // Tickets for Event 3
        Ticket::create([
            'event_id' => 3,
            'ticket_name' => 'Webinar Access',
            'ticket_price' => 20.00,
        ]);

        // Tickets for Event 4
        Ticket::create([
            'event_id' => 4,
            'ticket_name' => 'Meetup Entry',
            'ticket_price' => 10.00,
        ]);
    }
}

