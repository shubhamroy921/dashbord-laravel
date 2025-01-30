<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        \Log::info('User Role in Middleware: ' . Auth::user()->role); // Log the role

        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return $next($request); // Proceed if the user is an admin
            } else {
                \Log::info('Redirecting user due to insufficient role.');
                return redirect()->route('login')->with('error', 'You do not have access to this page.');
            }
        }

        return redirect()->route('login'); // Redirect to login if not authenticated
    }
}
