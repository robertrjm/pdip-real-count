<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        // Check if the request expects a JSON response
        if ($request->expectsJson()) {
            return null; // Do not redirect, just return a 401 response
        }

        // Default redirect to login page
        return route('login');
    }

    /**
     * Additional redirection logic for specific roles (if needed).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function handleRedirectForRole(Request $request): ?string
    {
        if (auth()->check()) {
            // Example: Redirect users to different dashboards based on their role
            switch (auth()->user()->role) {
                case 'superadmin':
                    return route('superadmin.dashboard');
                case 'admin':
                    return route('admin.dashboard');
                default:
                    return route('home'); // Default route for other users
            }
        }

        return null; // No redirection if not authenticated
    }
}
