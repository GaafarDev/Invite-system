<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'signup',
        'login',
        'users/*',
        'events',
        'events/*',
        'invitations',
        'invitations/*',
        'ticket-sales',
        'ticket-sales/*',
        'tickets',
        'tickets/*',
        'interests',
        'interests/*',
        'api/*',
    ];
}
