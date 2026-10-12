<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class UpdateLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $profile = $user->profile;
            if (
                $profile &&
                (
                    $profile->last_seen_at === null ||
                    $profile->last_seen_at->lt(now()->subMinutes(2))
                )
            ) {
                $profile->update([
                    'last_seen_at' => now(),
                ]);
            }
        }
        return $next($request);
    }
}