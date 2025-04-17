<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika permintaan adalah OPTIONS, kirimkan respons tanpa melanjutkan ke logika aplikasi
        if ($request->getMethod() == "OPTIONS") {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', 'https://doorasi.com')  // Ganti dengan domain yang diizinkan
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Authorization')
                ->header('Access-Control-Allow-Credentials', 'true');  // Menambahkan support untuk kredensial
        }

        // Menambahkan header CORS untuk permintaan lainnya
        return $next($request)
            ->header('Access-Control-Allow-Origin', 'https://doorasi.com')  // Ganti dengan domain yang diizinkan
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Authorization')
            ->header('Access-Control-Allow-Credentials', 'true');  // Menambahkan support untuk kredensial
    }
}
