<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interest;

class InterestController extends Controller
{
    public function index()
    {
        $interests = Interest::all();
        return response()->json($interests, 200);
    }

    public function show($id)
    {
        $interest = Interest::findOrFail($id);
        return response()->json($interest, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $interest = Interest::create($validatedData);
        return response()->json($interest, 201);
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $interest = Interest::where('event_id', $validatedData['event_id'])
            ->where('user_id', $validatedData['user_id'])
            ->first();

        if ($interest) {
            $interest->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Interest not found.'], 404);
        }
    }
}
