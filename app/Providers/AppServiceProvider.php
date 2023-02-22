<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('routeactive', function ($route) {
			return "<?php echo Route::currentRouteNamed($route) ? 'class=\"active\"' : '' ?>";
		});

        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->isAdmin();
        });
    }
}
