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

        // TAMBAHAN: Cek apakah user_status adalah 'nonaktif'
        if ($user->user_status === 'nonaktif') {
            // Logout user
            Auth::logout();
            
            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect ke halaman login dengan pesan error
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi contact person untuk informasi lebih lanjut.');
        }
        
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
                return redirect()->route('admin-dashboard');
            case 'staff':
                return redirect()->route('staff-dashboard');
            case 'user':
                return redirect()->route('user-katalog');
            case 'guest':
                return redirect()->route('welcome');
            default:
                return redirect()->route('welcome');
        }
    }
}