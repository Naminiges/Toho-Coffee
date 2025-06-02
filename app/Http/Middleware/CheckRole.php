<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Jika tidak ada role yang dispesifikasi, lanjutkan request
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah user memiliki salah satu role yang diizinkan
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // Jika user tidak memiliki role yang sesuai, redirect berdasarkan role mereka
        return $this->redirectBasedOnRole($user->role);
    }

    /**
     * Redirect user berdasarkan role mereka
     */
    private function redirectBasedOnRole(string $role): Response
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('dashboard');
            case 'staff':
                return redirect()->route('staff.dashboard');
            case 'user':
                return redirect()->route('katalog');
            case 'guest':
                return redirect()->route('welcome');
            default:
                return redirect()->route('welcome');
        }
    }
}