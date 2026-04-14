<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerAuth
{
    public function handle(Request $request, Closure $next): mixed
    {
        // Check if manager is authenticated
        if (!Auth::guard('manager')->check()) {
            return redirect()->route('manager.login');
        }

        $manager = Auth::guard('manager')->user();

        // Check if manager is active
        if (!$manager->is_active) {
            Auth::guard('manager')->logout();
            return redirect()->route('manager.login')->with('error', __('Your account has been deactivated.'));
        }

        // Add security headers
        $response = $next($request);
        
        if (method_exists($response, 'header')) {
            $response->header('X-Frame-Options', 'DENY');
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('X-XSS-Protection', '1; mode=block');
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        }

        return $response;
    }
}
