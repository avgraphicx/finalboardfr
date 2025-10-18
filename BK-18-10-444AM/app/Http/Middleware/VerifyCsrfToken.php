<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * Note: We exclude the payments/test endpoint so the frontend test call
     * can hit a JSON response even when session/CSRF inconsistencies occur.
     *
     * @var array<int, string>
     */
    protected $except = [
        'payments/test',
        // add other URIs here if you need to exclude them from CSRF verification
    ];
}
