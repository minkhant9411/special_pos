<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceLimitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $sessionId = $request->session()->getId();
            $user = Auth::user();

            $validSession = $user->sessions()
                ->where('session_id', $sessionId)
                ->where('last_activity', '>=', now()->subMinutes(config('session.lifetime')))
                ->exists();

            if (!$validSession) {
                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('login')->with('error', 'You can only be logged in on 3 devices at a time.');
            }

            // Update last activity
            $user->sessions()
                ->where('session_id', $sessionId)
                ->update(['last_activity' => now()]);
        }

        return $next($request);
    }
}
