<?php

namespace App\Middleware;

use Closure;

class Authenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (! isset($_SESSION['user'])) {
            return 'Error Authenticate. Please <a href="/login">login</a>';
        }

        return $next($request);
    }
}
