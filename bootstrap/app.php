<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // Make sure this use statement is present

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) { // <<< THIS IS THE FUNCTION
        // Add your middleware aliases here
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            // You can also add other standard aliases if needed,
            // though many are auto-discovered or handled differently in L11.
            // For instance, 'auth' and 'guest' are often automatically available
            // if you've set up authentication (e.g., with Breeze).
            // Check Laravel 11 docs for which aliases might still be useful to define here.
            // For now, just adding 'admin' is the primary goal.
        ]);

        // You can also register global middleware:
        // $middleware->append(YourGlobalMiddleware::class);

        // Or middleware groups:
        // $middleware->group('web', [
        //     // ... web middleware (many are now auto-included)
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
