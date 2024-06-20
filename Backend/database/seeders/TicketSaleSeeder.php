<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketSale;
use App\Models\User;
use App\Models\Ticket;



class TicketSaleSeeder extends Seeder
{
    public function run()
    {
        // User 1 with Ticket IDs 1, 2, 3
        $this->createTicketSales(1, [1, 2, 3]);

        // User 2 with Ticket IDs 1, 2, 3, 4, 5, 6
        $this->createTicketSales(2, [1, 2, 3, 4, 5, 6]);
    }

    private function createTicketSales($userId, $ticketIds)
    {
        $user = User::findOrFail($userId);

        foreach ($ticketIds as $ticketId) {
            $ticket = Ticket::findOrFail($ticketId);

            // Create TicketSale entry
            TicketSale::create([
                'user_id' => $user->id,
                'ticket_id' => $ticket->id,
                'quantity' => 1, // Set a default quantity or adjust as needed
            ]);
        }
    }
}

