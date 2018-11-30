<?php

namespace FuquIo\LaravelFakeId;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use FuquIo\LaravelFakeId\Commands\FakeIdSetupCommand;
use Jenssegers\Optimus\Optimus;

/**
 * Class ServiceProvider
 * @package FuquIo\LaravelCors
 */
class ServiceProvider extends BaseServiceProvider{
	CONST VENDOR_PATH = 'fuqu-io/laravel-fakeid';
	CONST SHORT_NAME = 'fuqu-fakeid';

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(){
		$this->bootConfig();

	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register(){
		$this->registerCommand();
		$this->registerOptimusAsAlias();
	}


	/**
	 * @internal
	 */
	private function bootConfig(){
		$this->publishes([__DIR__ . '/../config/main.php' => config_path(SELF::SHORT_NAME . '.php')]);
		$this->mergeConfigFrom(__DIR__ . '/../config/main.php', SELF::SHORT_NAME);
	}

	/**
	 * Register the Optimus container.
	 *
	 * @return void
	 */
	protected function registerOptimusAsAlias(){
		$this->app->singleton(FakeId::class, function ($app){
			return new Optimus(
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
			return new FakeIdSetupCommand();
		});

		$this->commands('fakeid.command.setup');
	}
}