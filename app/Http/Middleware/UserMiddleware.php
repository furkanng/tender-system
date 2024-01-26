<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard("user")->user();
        if (auth()->guard("user")->check() && $user->role != 0) {
            return $next($request);
        } else {
            return redirect()->route("front.login")->with('error', 'Yetkili Role Sahip Değilsiniz!');
        }

    }
}
