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

    public function getByTicketId($ticketId)
    {
        try {
            // Validate if ticketId is numeric
            if (!is_numeric($ticketId)) {
                return response()->json(['message' => 'Invalid ticket ID'], 400);
            }

            // Retrieve all ticket sales for the given ticket ID
            $ticketSales = TicketSale::where('ticket_id', $ticketId)->get();

            return response()->json($ticketSales, 200);
        } catch (\Exception $e) {
            // Log the exception message for debugging
            \Log::error('Error in getByTicketId method: ' . $e->getMessage());
            // Return a generic error response
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}

