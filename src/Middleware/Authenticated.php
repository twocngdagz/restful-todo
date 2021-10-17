<?php

namespace App\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Authenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (! isset($_SESSION['user'])) {
            if ($request->ajax() || $request->wantsJson()) {
                return [
                    'errors' => [
                        'status' => 401,
                        'detail' => 'Unauthorized'
                    ]
                ];
            } else {
                throw new HttpException(401, 'Unauthorized', null);
            }
        }

        return $next($request);
    }
}
