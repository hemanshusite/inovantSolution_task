<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // public const HOME = '/home';
    protected $namespace = 'App\Http\Controllers';
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            Route::prefix('webadmin')
                ->middleware('web')
                ->group(base_path('routes/web_backend.php'));
            Route::prefix('webservices/v1')
                ->middleware('api')
                ->group(base_path("routes/web_api.php"));
        });
    }
}