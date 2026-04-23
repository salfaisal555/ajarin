<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ForceChangePassword
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user login, dan passwordnya adalah "siswa123"
        if (Auth::check() && Hash::check('siswa123', Auth::user()->password)) {

            // Biarkan lewat JIKA user sedang berada di halaman ganti password atau sedang proses logout
            if (! $request->routeIs('password.force_change') &&
                ! $request->routeIs('password.force_update') &&
                ! $request->routeIs('logout')) {

                return redirect()->route('password.force_change');
            }
        }

        return $next($request);
    }
}
