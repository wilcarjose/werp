<?php

namespace Werp\Modules\Core\Purchases\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Werp\Modules\Core\Purchases\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Config::set('purchases', require app_path('Modules/Core/Purchases/config/module.php'));
        $menu = config('menu');
        $purchases = config('purchases.menu');
        $menu[] = $purchases;
        \Config::set('menu', $menu);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        //
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {

        Route::group([
            'middleware' => ['web', 'admin', 'auth:admin'],
            'prefix' => 'admin/purchases',
            'as' => 'admin.purchases.',
            'namespace' => $this->namespace,
        ], function () {
            require(base_path('app/Modules/Core/Purchases/routes/admin.php'));
        });

        /*
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('app/Modules/Core/Purchases/routes/admin.php'));
        */
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('app/Modules/Core/Purchases/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('app/Modules/Core/Purchases/routes/api.php'));
    }
}
