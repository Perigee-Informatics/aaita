<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/district/province_id',
        '/api/locallevel/district_id',
        '/api/district/current_province_id',
        '/api/locallevel/current_district_id',
    ];
}
