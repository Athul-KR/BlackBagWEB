<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\Log;
try {
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
    })->create();
    $app->singleton(
        Illuminate\Contracts\Http\Kernel::class,
        HttpKernel::class
    );
    return $app;
} catch (\Exception $e) {
   
    Log::error('Error during application setup: ' . $e->getMessage());
    // Optionally, rethrow the exception
    throw $e;
}
