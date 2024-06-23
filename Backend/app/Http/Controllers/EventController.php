<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Invitation;
use App\Models\TicketSale;
use App\Models\Ticket;
use App\Models\User;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['tickets', 'interests'])->get();
        return response()->json($events, 200);
    }

//     public function upcoming(Request $request)
// {
//     try {
//         $request->validate([
//             'user_id' => 'required|integer',
//         ]);

//         $userId = $request->input('user_id');

//         // Retrieve all ticket sales for the user
//         $ticketSales = TicketSale::where('user_id', $userId)->get();

//         // Initialize an empty array to store unique events
//         $events = [];

//         // Iterate through each TicketSale to get the associated Event
//         foreach ($ticketSales as $ticketSale) {
//             $ticket = Ticket::find($ticketSale->ticket_id);

//             // If the ticket exists and has an event, add it to the events array
//             if ($ticket && $ticket->event) {
//                 $events[] = $ticket->event;
//             }
//         }

//         // Filter and return unique events based on event ID
//         $uniqueEvents = collect($events)->unique('id')->values();

//         return response()->json($uniqueEvents, 200);
//     } catch (\Exception $e) {
//         // Log the exception message for debugging
//         \Log::error('Error in upcoming method: ' . $e->getMessage());
//         // Return a generic error response
//         return response()->json(['message' => 'Internal Server Error'], 500);
//     }
// }
public function upcoming(Request $request, $userId)
{
    try {
        // Validate if userId is numeric
        if (!is_numeric($userId)) {
            return response()->json(['message' => 'Invalid user ID'], 400);
        }

        // Retrieve all ticket sales for the user
        $ticketSales = TicketSale::where('user_id', $userId)->get();

        // Retrieve all accepted invitations for the user
        $acceptedInvitations = Invitation::where('user_id', $userId)
                                          ->whereIn('status', ['accepted', 'Accepted'])
                                          ->get();

        // Initialize an empty array to store events
        $events = [];

        // Iterate through each TicketSale to get the associated Event
        foreach ($ticketSales as $ticketSale) {
            $ticket = Ticket::find($ticketSale->ticket_id);
            if ($ticket && $ticket->event) {
                $events[] = $ticket->event;
            }
        }

        // Iterate through each Invitation to get the associated Event
        foreach ($acceptedInvitations as $invitation) {
            $event = Event::find($invitation->event_id);
            if ($event) {
                $events[] = $event;
            }
        }

        // Filter and return unique events based on event ID
        $uniqueEvents = collect($events)->unique('id')->values();

        return response()->json($uniqueEvents, 200);
    } catch (\Exception $e) {
        \Log::error('Error in upcoming method: ' . $e->getMessage());
        return response()->json(['message' => 'Internal Server Error'], 500);
    }
}


    

    public function show($id)
    {
        $event = Event::with(['tickets', 'interests'])->findOrFail($id);
        return response()->json($event, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date',
            'location' => 'required|string|max:255',
            'image_link' => 'nullable|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
            'tickets' => 'required|array',
            'tickets.*.ticket_name' => 'required|string|max:255',
            'tickets.*.ticket_price' => 'required|numeric|min:0',
        ]);

        $event = Event::create($validatedData);

        foreach ($validatedData['tickets'] as $ticketData) {
            $event->tickets()->create($ticketData);
        }

        return response()->json($event->load('tickets'), 201);
    }

    public function userCreatedEvents($userId)
    {
        $events = Event::where('user_id', $userId)->with(['tickets', 'interests'])->get();
        return response()->json($events, 200);
    }
}

