<?php

namespace Werp\Modules\JMJ\POS\Providers;

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
    protected $namespace = 'Werp\Modules\JMJ\POS\Controllers';

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
        \Config::set('pos', require app_path('Modules/JMJ/POS/config/module.php'));
        $menu = config('menu');
        $module = config('pos.menu');
        $menu[] = $module;
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
            'prefix' => 'admin/pos',
            'as' => 'admin.pos.',
            'namespace' => $this->namespace,
        ], function () {
            require(base_path('app/Modules/JMJ/POS/routes/admin.php'));
        });

        /*
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('app/Modules/JMJ/POS/routes/admin.php'));
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
             ->group(base_path('app/Modules/JMJ/POS/routes/web.php'));
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
             ->group(base_path('app/Modules/JMJ/POS/routes/api.php'));
    }
}
