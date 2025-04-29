<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (auth()->attempt($fields)) {
            $request->session()->regenerate();
            $this->authenticated($request, auth()->user());
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function index(Request $request)
    {

        $message = $request->session()->get('message');
        $request->session()->put('message', null);
        return Inertia::render('Auth/Login', ['message' => $message]);
    }
    protected function authenticated(Request $request, $user)
    {
        $maxDevices = 3;
        $currentSessionId = \Session::getId();

        // Get all active sessions for this user
        $activeSessions = $user->sessions()
            ->where('last_activity', '>=', now()->subMinutes(config('session.lifetime')))
            ->count();

        // If user has reached device limit, remove the oldest session
        if ($activeSessions >= $maxDevices) {
            $request->session()->put('message', 'You can only be logged in on 3 devices at once. Please logout from another device.');

            // Clean up any existing session for this device
            $user->sessions()->where('session_id', $currentSessionId)->delete();
            DB::table('sessions')->where('id', $currentSessionId)->delete();

            // Perform logout
            $request->session()->put('message', 'Device limit reach.');
            auth()->logout();
            // $request->session()->invalidate();
            // Redirect to login
            return redirect()->route('login');
        }

        // Create new session record or update existing
        $user->sessions()->updateOrCreate(
            ['session_id' => $currentSessionId],
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'last_activity' => now()
            ]
        );

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {

        if (auth()->check()) {
            $sessionId = \Session::getId();
            auth()->user()->sessions()->where('session_id', $sessionId)->delete();
        }

        auth()->logout();
        $request->session()->invalidate();

        return redirect('/');
    }
}
