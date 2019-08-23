<?php

namespace Werp\Http\Middleware;

use Closure;

class DatabaseConnection
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'admin')
	{
        if (session('test_bd', false)) {
            config(['database.default' => 'user_tests']);
        }

        return $next($request);
	}
}