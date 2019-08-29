<?php

namespace Werp\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectToConfig
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
		if ($request->is('admin/maintenance/general_config/*')) {
			return $next($request);
		}

		if (!auth()->check()) {
			return $next($request);
		}

		if (session('company')->isRight()) {
			return $next($request);
		}

        return redirect(route('admin.maintenance.general_config.edit'));
	}
}