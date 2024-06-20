<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Invitation;
use App\Models\TicketSale;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function signup(Request $request)
{
    // Validate input data
    $validator = Validator::make($request->all(), [
        'fullname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:15',
        'gender' => 'required|string|max:10',
        'password' => 'required|string|min:8',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Create new user
    try {
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    } catch (\Exception $e) {
        // If creating user fails (unlikely in this scenario due to validation)
        \Log::error('Error creating user: ' . $e->getMessage());
        return response()->json(['message' => 'Failed to create user'], 500);
    }
}


    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validatedData['username'])
            ->orWhere('phone', $validatedData['username'])
            ->first();

        if ($user && Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['id' => $user->id], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'fullname' => 'sometimes|string|max:255',
            'website' => 'sometimes|string|max:255',
            'company' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:15',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'country' => 'sometimes|string|max:255',
            'postcode' => 'sometimes|string|max:10',
            'pic_url' => 'sometimes|string|max:255',
        ]);
        $user->update($validatedData);
        return response()->json($user, 200);
    }

    public function updateEmail(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user->email = $request->input('email');
        $user->save();

        return response()->json($user, 200);
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'password' => 'required|string|min:8',
        ]);
        $user->update(['password' => Hash::make($validatedData['password'])]);
        return response()->json($user, 200);
    }
}

