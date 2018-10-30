<?php namespace Udla\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

/**
 * The application's global HTTP middleware stack.
 *
 * @var array
 */
protected $middleware = [
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
		\Udla\Http\Middleware\TrimStrings::class,
		\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
		\Barryvdh\Cors\HandleCors::class,
];

/**
 * The application's route middleware groups.
 *
 * @var array
 */
protected $middlewareGroups = [
		'web' => [
				\Udla\Http\Middleware\EncryptCookies::class,
				\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
				\Illuminate\Session\Middleware\StartSession::class,
				// \Illuminate\Session\Middleware\AuthenticateSession::class,
				\Illuminate\View\Middleware\ShareErrorsFromSession::class,
				\Udla\Http\Middleware\VerifyCsrfToken::class,
				\Illuminate\Routing\Middleware\SubstituteBindings::class,
		],

		'api' => [
				'throttle:60,1',
				\Udla\Http\Middleware\EncryptCookies::class,
				\Illuminate\Session\Middleware\StartSession::class,
				'bindings',
		],
];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
		'can' => \Illuminate\Auth\Middleware\Authorize::class,
		'guest' => \Udla\Http\Middleware\RedirectIfAuthenticated::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'no-cache' =>	\Udla\Http\Middleware\NoHttpCache::class,
	];

}
