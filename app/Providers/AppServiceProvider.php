<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip() . '|' . strtolower((string) $request->input('email')))
                ->response(function (Request $request, array $headers) {
                    return back()->withErrors([
                        'email' => 'Demasiados intentos. Por favor espera un minuto e intenta de nuevo.',
                    ])->withHeaders($headers);
                });
        });
    }
}
