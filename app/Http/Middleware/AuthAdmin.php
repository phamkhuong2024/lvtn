<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated as khachhang (customer)
        if (Auth::guard('khachhang')->check()) {
            return redirect()->route('login');
        }

        // Check if user is authenticated as admin or nhanvien (employee)
        if (Auth::guard('admin')->check() || Auth::guard('nhanvien')->check()) {
            return $next($request);
        }

        // If not authenticated at all, redirect to login
        return redirect()->route('login');
    }
}
