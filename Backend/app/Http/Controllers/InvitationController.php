<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Invitation;
use App\Models\TicketSale;
use App\Models\Ticket;
use App\Models\User;

class InvitationController extends Controller
{ 
    public function index()
    {
        $invitations = Invitation::all();
        return response()->json($invitations, 200);
    }
    public function userInvitations($userId)
    {
        $invitations = Invitation::where('user_id', $userId)
                                 ->where('status', 'pending')
                                 ->get();
    
        return response()->json($invitations, 200);
    }
    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'user_id' => 'required|array',
            'user_id.*' => 'required|integer|exists:users,id',
        ]);
    
        $invitations = [];
        $now = now(); // Gets the current timestamp
    
        foreach ($validatedData['user_id'] as $userId) {
            $invitation = Invitation::create([
                'event_id' => $validatedData['event_id'],
                'user_id' => $userId,
                'datetime' => $now, // Assign the current timestamp to 'datetime'
            ]);
    
            $invitations[] = $invitation;
        }
    
        return response()->json($invitations, 201);
    }

    public function respondInvitation(Request $request, $invitation_id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:accepted,rejected',
        ]);

        $invitation = Invitation::findOrFail($invitation_id);
        $invitation->status = $validatedData['status'];
        $invitation->save();

        return response()->json($invitation, 200);
    }
    
}

