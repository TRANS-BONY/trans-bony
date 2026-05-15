<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    /*
    |--------------------------------------------------------------------------
    | ROUTES
    |--------------------------------------------------------------------------
    */
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )

    /*
    |--------------------------------------------------------------------------
    | MIDDLEWARE
    |--------------------------------------------------------------------------
    */
    ->withMiddleware(function (Middleware $middleware) {

        // Middleware globaux (optionnel)
        $middleware->append([
            \App\Http\Middleware\UpdateRoleActivity::class,
        ]);

        // Alias middleware IMPORTANT
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'permission' => \App\Http\Middleware\PermissionMiddleware::class,
            'audit' => \App\Http\Middleware\LogActivity::class,
            'active' => \App\Http\Middleware\CheckActiveUser::class,
            'check.role' => \App\Http\Middleware\RedirectIfNoRole::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'logout',
        ]);

    })

    /*
    |--------------------------------------------------------------------------
    | EXCEPTIONS
    |--------------------------------------------------------------------------
    */
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('alerts:check')->daily();
    })

    ->create();
