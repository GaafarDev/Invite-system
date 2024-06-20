<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Invitation;
use App\Models\TicketSale;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json($tickets, 200);
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return response()->json($ticket, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'ticket_name' => 'required|string|max:255',
            'ticket_price' => 'required|numeric|min:0',
        ]);

        $ticket = Ticket::create($validatedData);
        return response()->json($ticket, 201);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $validatedData = $request->validate([
            'ticket_name' => 'sometimes|string|max:255',
            'ticket_price' => 'sometimes|numeric|min:0',
        ]);
        $ticket->update($validatedData);
        return response()->json($ticket, 200);
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return response()->json(null, 204);
    }

    public function eventTickets($eventId)
    {
        $tickets = Ticket::where('event_id', $eventId)->get();
        return response()->json($tickets, 200);
    }
}

