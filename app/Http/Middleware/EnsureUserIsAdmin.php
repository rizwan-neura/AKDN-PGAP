<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless($user && $user->isActive(), 403, 'Your account is inactive.');
        abort_unless($user->isAdmin(), 403, 'Administrator access is required.');

        return $next($request);
    }
}
