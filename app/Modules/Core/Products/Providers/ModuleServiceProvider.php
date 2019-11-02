<?php

namespace Werp\Modules\Core\Products\Providers;

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
    protected $namespace = 'Werp\Modules\Core\Products\Controllers';

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
        \Config::set('products', require app_path('Modules/Core/Products/config/products.php'));
        $menu = config('menu');
        $products = config('products.menu');
        $menu[] = $products;
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
            'prefix' => 'admin/products',
            'as' => 'admin.products.',
            'namespace' => $this->namespace,
        ], function () {
            require(base_path('app/Modules/Core/Products/routes/admin.php'));
        });
        
        /*
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('app/Modules/Core/Products/routes/admin.php'));
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
             ->group(base_path('app/Modules/Core/Products/routes/web.php'));
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
        Route::prefix('api/admin/products')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('app/Modules/Core/Products/routes/api.php'));
    }
}
