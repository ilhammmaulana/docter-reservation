<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::directive('authOrDocter', function () {
            return "<?php if((auth('docter')->check() && auth('docter')->user()->hasRole('docter')) || (auth('web')->check() && auth('web')->user()->hasRole('admin'))): ?>";
        });

        Blade::directive('endauthOrDocter', function () {
            return "<?php endif; ?>";
        });
        Blade::directive('guestOrNotAdminOrDocter', function () {
            return "<?php if(!(auth('web')->check())&& !(auth('docter')->check())): ?>";
        });

        Blade::directive('endguestOrNotAdminOrDocter', function () {
            return "<?php endif; ?>";
        });
        Blade::directive('docter', function () {
            return "<?php if(isDocter()): ?>";
        });

        Blade::directive('endDocter', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
