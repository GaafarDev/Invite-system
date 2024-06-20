<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\TicketSaleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\InterestController;

Route::middleware('api')->group(function () {
    // User routes
    Route::get('users', [UserController::class, 'index']); // Get all users
    Route::post('signup', [UserController::class, 'signup']);
    Route::post('login', [UserController::class, 'login']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::put('users/{id}/email', [UserController::class, 'updateEmail']);
    Route::put('users/{id}/password', [UserController::class, 'updatePassword']);

    // Event routes
    Route::get('events', [EventController::class, 'index']); // Get all events
    Route::get('events/upcoming/{userId}', [EventController::class, 'upcoming']);
    Route::get('events/{id}', [EventController::class, 'show']);
    Route::post('events', [EventController::class, 'store']);
    Route::get('users/{userId}/createdevents', [EventController::class, 'userCreatedEvents']);
    // Route::get('events/upcoming', [EventController::class, 'upcoming']);

    // Invitation routes
    Route::get('invitations', [InvitationController::class, 'index']); // Get all invitations
    Route::get('users/{userId}/invitations', [InvitationController::class, 'userInvitations']);
    Route::post('invitations', [InvitationController::class, 'store']);
    Route::put('invitations/{invitation_id}/respond', [InvitationController::class, 'respondInvitation']);

    // TicketSale routes
    Route::get('ticketsales', [TicketSaleController::class, 'index']); // Get all ticket sales
    Route::post('ticketsales', [TicketSaleController::class, 'store']);
    Route::get('users/{userId}/ticket-sales', [TicketSaleController::class, 'userTicketSales']); // Route added for user ticket sales

    // Ticket routes
    Route::get('tickets', [TicketController::class, 'index']); // Get all tickets
    Route::post('tickets', [TicketController::class, 'store']);
    Route::get('events/{eventId}/tickets', [TicketController::class, 'eventTickets']); // Route for event-specific tickets
    // Route::put('tickets/{id}', [TicketController::class, 'update']);
    // Route::delete('tickets/{id}', [TicketController::class, 'destroy']);
    // Route::get('tickets/{id}', [TicketController::class, 'show']);
    
    // Interest routes
    Route::get('interests', [InterestController::class, 'index']);
    Route::post('interests', [InterestController::class, 'store']);
    Route::delete('interests', [InterestController::class, 'destroy']);
    // Route::get('interests/{id}', [InterestController::class, 'show']);
});
