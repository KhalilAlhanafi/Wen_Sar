<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        // Store intended role in session if provided
        if ($request->has('role')) {
            $request->session()->put('intended_role', $request->role);
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Check if user is logging in through a specific role portal
        if ($request->session()->has('intended_role')) {
            $intendedRole = $request->session()->get('intended_role');
            $request->session()->forget('intended_role');

            // If user's role doesn't match the portal they tried to use, reject
            if (!$user->hasRole($intendedRole)) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $roleName = $intendedRole === 'owner' ? 'صاحب نشاط تجاري' : 'مستخدم عادي';
                return redirect()->route('login')->withErrors([
                    'email' => 'هذا الحساب مسجل كـ ' . ($user->hasRole('owner') ? 'صاحب نشاط تجاري' : 'مستخدم عادي') . '. يرجى استخدام البوابة الصحيحة للدخول.',
                ]);
            }
        }

        $request->session()->regenerate();

        // All users go to home page after login
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
