<?php
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\EventController;
// use App\Http\Controllers\InvitationController;
// use App\Http\Controllers\TicketSaleController;
// use App\Http\Controllers\TicketController;
// use App\Http\Controllers\InterestController;

// // User routes
// Route::post('signup', [UserController::class, 'signup']);
// Route::post('login', [UserController::class, 'login']);
// Route::get('users/{id}', [UserController::class, 'show']);
// Route::put('users/{id}', [UserController::class, 'update']);
// Route::put('users/{id}/email', [UserController::class, 'updateEmail']);
// Route::put('users/{id}/password', [UserController::class, 'updatePassword']);

// // Event routes
// Route::get('events', [EventController::class, 'index']);
// Route::get('events/upcoming', [EventController::class, 'upcoming']);
// Route::get('events/{id}', [EventController::class, 'show']);
// Route::post('events', [EventController::class, 'store']);
// Route::get('users/{userId}/events', [EventController::class, 'userEvents']);

// // Invitation routes
// Route::get('users/{userId}/invitations', [InvitationController::class, 'userInvitations']);
// Route::post('invitations', [InvitationController::class, 'store']);

// // TicketSale routes
// Route::post('ticket-sales', [TicketSaleController::class, 'store']);

// // Ticket routes
// Route::get('tickets', [TicketController::class, 'index']);
// Route::get('tickets/{id}', [TicketController::class, 'show']);
// Route::post('tickets', [TicketController::class, 'store']);
// Route::put('tickets/{id}', [TicketController::class, 'update']);
// Route::delete('tickets/{id}', [TicketController::class, 'destroy']);

// // Interest routes
// Route::get('interests', [InterestController::class, 'index']);
// Route::get('interests/{id}', [InterestController::class, 'show']);
// Route::post('interests', [InterestController::class, 'store']);
// Route::put('interests/{id}', [InterestController::class, 'update']);
// Route::delete('interests/{id}', [InterestController::class, 'destroy']);