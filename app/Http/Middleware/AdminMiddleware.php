<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();

        if (! $user || ! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
