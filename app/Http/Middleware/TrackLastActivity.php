<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check() && $request->user() instanceof User) {
            $user = $request->user();

            if (! $user->last_login_at || $user->last_login_at->diffInDays(now()) >= 1) {
                $user->updateQuietly(['last_login_at' => now()]);
            }
        }

        return $next($request);
    }
}
