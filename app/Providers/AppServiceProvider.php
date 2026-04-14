<?php
//
//namespace App\Providers;
//
//use Illuminate\Support\ServiceProvider;
//
//class AppServiceProvider extends ServiceProvider
//{
//    /**
//     * Register any application services.
//     */
//    public function register(): void
//    {
//        //
//    }
//
//    /**
//     * Bootstrap any application services.
//     */
//    public function boot(): void
//    {
//        Schema::defaultStringLength(191);
//    }
//}


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        Route::prefix('api')
        ->middleware('api')
        ->group(base_path('routes/api.php'));
    }
}
