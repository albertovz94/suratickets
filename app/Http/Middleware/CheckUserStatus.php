<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Verify the authenticated user has an active account status.
     * Users with 'Bloqueada' or 'Inactivo' status are logged out.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && in_array(Auth::user()->status, ['Bloqueada', 'Inactivo'])) {
            $status = Auth::user()->status;
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $status === 'Bloqueada'
                ? 'Tu cuenta ha sido bloqueada. Contacta al administrador.'
                : 'Tu cuenta está inactiva. Contacta al administrador.';

            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}
