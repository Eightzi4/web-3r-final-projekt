<?php

namespace App\Http\Controllers;

// For Laravel 9+ (may vary slightly by exact version, but general structure is this)
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests; // For Laravel 9+ (or `DispatchesJobs` in older versions)
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController // <<< MUST extend BaseController
{
    use AuthorizesRequests, ValidatesRequests; // <<< Traits providing functionality
}
