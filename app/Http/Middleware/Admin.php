<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{

    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Please login to access this page.');
        }

        $user = Auth::user();

        // Check role-specific access
        if ($role === 'admin') {
            if ($user->role !== 'admin') {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
        }

        if ($role === 'super admin') {
            if ($user->role !== 'super admin') {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
        }

        // Example: Prevent admin from accessing super_admin-specific routes
        if ($role === 'super admin' && $user->role === 'admin') {
            return redirect('/')->with('error', 'Admin cannot access this route.');
        }

        return $next($request);
    }
}
