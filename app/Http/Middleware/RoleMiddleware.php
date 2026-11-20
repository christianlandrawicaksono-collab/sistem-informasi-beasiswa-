<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard')->with('error', 'Akses tidak diizinkan untuk peran Anda.'),
                'reviewer' => redirect()->route('reviewer.dashboard')->with('error', 'Akses tidak diizinkan untuk peran Anda.'),
                default => redirect()->route('mahasiswa.dashboard')->with('error', 'Akses tidak diizinkan untuk peran Anda.'),
            };
        }

        return $next($request);
    }
}
