<?php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // Registering the middleware globally (applies to all routes)
    protected $middleware = [
       
        // other global middlewares...
    ];

    // Registering middleware for specific routes
    protected $routeMiddleware = [
        'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
        // other route-specific middlewares...
    ];
    
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\VerifyCsrfToken::class,  // CSRF protection is enforced here
        ],
        'api' => [
                'throttle:api',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
    ];
}
