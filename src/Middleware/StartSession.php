<?php
namespace App\Middleware;

use Closure;

class StartSession
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $next($request);
    }
}
