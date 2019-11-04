<?php

namespace Werp\Providers;

use Werp\User;
use Werp\Observers\UserObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
//use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);

        view()->composer('*', function ($view) {
            if ($route = \Request::route()) {
                $current_route_name = $route->getName();
                $group = get_route_group($current_route_name);
                $view->with('current_route_group', $group)
                    ->with('current_route_name', $current_route_name);
            }
        });

        //Resource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }
}
