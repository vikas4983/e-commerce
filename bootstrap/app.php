<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,

        ]);
        // For specific api routes
        $middleware->alias([
            'set.locale' => \App\Http\Middleware\SetLocaleFromHeader::class,
            'guest.token' => \App\Http\Middleware\EnsureGuestTokenExists::class,
        ]);
        // For all API Routes
        // $middleware->api(append: [
        //     \App\Http\Middleware\EnsureGuestTokenExists::class, 
        // ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
