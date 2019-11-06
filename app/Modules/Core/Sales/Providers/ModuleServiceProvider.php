<?php

namespace Werp\Modules\Core\Sales\Providers;

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
    protected $namespace = 'Werp\Modules\Core\Sales\Controllers';

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
        \Config::set('sales', require app_path('Modules/Core/Sales/config/sales.php'));
        $menu = config('menu');
        $sales = config('sales.menu');
        $menu[] = $sales;
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
            'prefix' => 'admin/sales',
            'as' => 'admin.sales.',
            'namespace' => $this->namespace,
        ], function () {
            require(base_path('app/Modules/Core/Sales/routes/admin.php'));
        });
        
        /*
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('app/Modules/Core/Sales/routes/admin.php'));
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
             ->group(base_path('app/Modules/Core/Sales/routes/web.php'));
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
        Route::prefix('api/admin/sales')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('app/Modules/Core/Sales/routes/api.php'));
    }
}
