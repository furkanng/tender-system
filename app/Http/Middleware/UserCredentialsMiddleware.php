<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCredentialsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard("user")->user();
        if (empty($user->city) || empty($user->district) || empty($user->address) || empty($user->phone)) {
            return redirect()->route("user.home")->with('error', 'Lütfen Adres Bilgilerinizi Eksiksiz Doldurunuz.');
        }else {
            return $next($request);
        }
    }
}
