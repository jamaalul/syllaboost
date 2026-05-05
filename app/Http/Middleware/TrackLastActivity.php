<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check() && $request->user() instanceof \App\Models\User) {
            $user = $request->user();
            
            if (! $user->last_login_at || $user->last_login_at->diffInDays(now()) >= 1) {
                $user->updateQuietly(['last_login_at' => now()]);
            }
        }

        return $next($request);
    }
}
