<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Invitation;
use App\Models\TicketSale;
use App\Models\Ticket;
use App\Models\User;

class TicketSaleController extends Controller
{   
    public function index()
    {
        $ticketsales = TicketSale::all();
        return response()->json($ticketsales, 200);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            // 'event_id' => 'required|integer|exists:events,id',
            'ticket_id' => 'required|integer|exists:tickets,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $ticketSale = TicketSale::create($validatedData);

        return response()->json($ticketSale, 201);
    }

    public function userTicketSales($userId)
    {
        $ticketSales = TicketSale::where('user_id', $userId)->get();
        return response()->json($ticketSales, 200);
    }
}

