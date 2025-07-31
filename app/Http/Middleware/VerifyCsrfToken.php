<?php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'track/*','healthscribe/*','smartmeter/*','dosespot/notifications'   // Exclude 'track/*' routes from CSRF verification
        // Add any other routes you want to exclude here
    ];
}
