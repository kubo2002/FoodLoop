<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLanguage
{
    public function handle($request, Closure $next)
    {
        \Log::info('SetLanguage executed', [
            'session_locale' => session('locale'),
            'app_locale' => app()->getLocale()
        ]);

        if (session()->has('locale')) {
            App::setLocale(session('locale'));
        }

        return $next($request);
    }
}

