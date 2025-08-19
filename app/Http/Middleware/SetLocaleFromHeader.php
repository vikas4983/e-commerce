<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rawLocale = $request->header('Accept-Language', 'en');
        $locale = strtolower(trim(explode(',', explode(';', $rawLocale)[0])[0]));


        if (!in_array($locale, ['en', 'hi', 'es'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
