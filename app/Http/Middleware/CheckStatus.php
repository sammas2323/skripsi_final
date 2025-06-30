<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->status == 'active'){
            return $next($request);
        }elseif($request->user()->status == 'verify'){
            return redirect('/verify');
            if ($request->is('verify') || $request->is('verify/*')) {
                return $next($request); // Izinkan akses ke halaman verifikasi
            }
            return redirect('/verify'); // Arahkan ke halaman verifikasi
        }
        return abort(403, 'Access denied.');
    }
}