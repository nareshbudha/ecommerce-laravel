<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
          // Check if the user is authenticated
      if (Auth::check()) {
        // Check if the authenticated user is an admin (case-insensitive check)
         if (strtolower(Auth::user()->Usertype) == 'admin') {
            // Proceed with the next middleware request (admin routes)
            return $next($request);
         } else {
            // If the user is not an admin, clear the session and redirect to login
            Session::flush();
             return redirect()->route('login');
        }
     } else {
        // If the user is not authenticated, redirect to login
        return redirect()->route('login');
     }
    }
}
