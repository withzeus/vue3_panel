<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * Display the secure authentication viewport.
     */
    public function index(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle an incoming authentication request validation loop.
     */
    public function store(Request $request)
    {
        // 1. Structural Sanity Validation
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        // 2. Attempt Session Authentication
        if (Auth::attempt($credentials, $remember)) {
            // Regenerate the session identifier to prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect to intended route path or fallback to the main dashboard
            return redirect()->intended(route('dashboard'));
        }

        // 3. Fallback: Throw Authentication Telemetry Failure
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session runtime node.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}