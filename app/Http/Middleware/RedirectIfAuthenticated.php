<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated as admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Check if user is authenticated as nhanvien (employee)
        if (Auth::guard('nhanvien')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Check if user is authenticated as khachhang (customer)
        if (Auth::guard('khachhang')->check()) {
            return redirect()->route('home');
        }

        // If not authenticated, allow access to the login/register page
        return $next($request);
    }
}
