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
     */
    public function handle(Request $request, Closure $next, $requiredRole): Response
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        // Konversi role string menjadi angka jika dibutuhkan
        $requiredRole = (int) $requiredRole;

        if ($userRole !== $requiredRole) {
            switch ($userRole) {
                case 1: // Admin
                    return redirect('/admin/dashboard')->with('error', 'Anda adalah admin dan tidak diizinkan mengakses halaman ini.');
                case 2: // Dosen
                    return redirect('/dosen/dashboard')->with('error', 'Anda adalah dosen dan tidak diizinkan mengakses halaman ini.');
                case 3: // Mahasiswa
                    return redirect('/mahasiswa/dashboard')->with('error', 'Anda adalah mahasiswa dan tidak diizinkan mengakses halaman ini.');
                default:
                    return redirect('/')->with('error', 'Role Anda tidak dikenali. Akses ditolak.');
            }
        }

        return $next($request);
    }
}
