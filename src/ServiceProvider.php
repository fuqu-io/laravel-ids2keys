<?php

namespace FuquIo\LaravelIds2Keys;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Routing\Router;

/**
 * Class ServiceProvider
 * @package FuquIo\LaravelCors
 */
class ServiceProvider extends BaseServiceProvider{
	CONST VENDOR_PATH = 'fuqu-io/fuqu-ids2keys';
	CONST SHORT_NAME = 'fuqu-ids2keys';

	/**
	 * Bootstrap the application services.
	 *
	 * @param Router $router
	 *
	 * @return void
	 */
	public function boot(Router $router){
		$this->bootConfig();
		$this->bootMiddleware($router);
		$this->bootRoutes();

	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register(){
		$this->registerOptimusAsAlias();
		$this->registerCommand();
	}


	/**
	 * @internal
	 */
	private function bootConfig(){
		$this->publishes([__DIR__ . '/../config/main.php' => config_path(SELF::SHORT_NAME . '.php')], 'config');
		$this->mergeConfigFrom(__DIR__ . '/../config/main.php', SELF::SHORT_NAME);
	}

	/**
	 * Register the Optimus container.
	 *
	 * @return void
	 */
	protected function registerOptimusAsAlias(){
		$this->app->singleton(FakeIdEngine::class, function ($app){
			return new FakeIdEngine(
				$app['config'][SELF::SHORT_NAME . '.prime'],
				$app['config'][SELF::SHORT_NAME . '.inverse'],
				$app['config'][SELF::SHORT_NAME . '.random']
			);
		});
	}

	/**
	 * Register the Artisan setup command.
	 *
	 * @return void
	 */
	protected function registerCommand(){
		$this->app->singleton('fakeid.command.setup', function ($app){
			return new SetupCommand();
		});

		$this->commands('fakeid.command.setup');
	}

	/**
	 * @internal
	 *
	 * @param Router $router
	 */
	private function bootMiddleware(Router $router){

		$x = array_search(\Illuminate\Routing\Middleware\SubstituteBindings::class, $router->middlewarePriority);
		array_splice($router->middlewarePriority, $x, 0, Middleware::class);

		$router->aliasMiddleware('keys2ids', Middleware::class);
		$router->aliasMiddleware('ids2keys', Middleware::class);


	}

	/**
	 * @internal
	 */
	private function bootRoutes(){

	}
}