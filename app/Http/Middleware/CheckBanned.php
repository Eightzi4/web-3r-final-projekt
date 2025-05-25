<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_banned) {
            Auth::logout(); // Log the banned user out
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('banned'); // Redirect to a "You are banned" page
        }
        return $next($request);
    }
}
