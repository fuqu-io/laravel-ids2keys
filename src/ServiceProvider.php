<?php

namespace FuquIo\LaravelFakeId;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use FuquIo\LaravelFakeId\Commands\FakeIdSetupCommand;

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
		$this->bootMigrations();

	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register(){
		$this->registerConfig();
		$this->registerCommand();
		$this->registerOptimus();
	}


	/**
	 * @internal
	 */
	private function bootConfig(){
		$this->publishes([__DIR__ . '/../config/main.php' => config_path(SELF::SHORT_NAME . '.php')]);
		//$this->mergeConfigFrom(__DIR__ . '/../config/main.php', SELF::SHORT_NAME);
	}

	/**
	 * @internal
	 */
	private function registerConfig(){
		//$this->publishes([__DIR__ . '/../config/main.php' => config_path(SELF::SHORT_NAME . '.php')]);
		$this->mergeConfigFrom(__DIR__ . '/../config/main.php', SELF::SHORT_NAME);
	}

	/**
	 * Register the Optimus container.
	 *
	 * @return void
	 */
	protected function registerOptimus(){
		$this->app->singleton('Jenssegers\Optimus\Optimus', function ($app){
			return new Optimus(
				$app['config']['fakeid.prime'],
				$app['config']['fakeid.inverse'],
				$app['config']['fakeid.random']
			);
		});

		$this->app->alias('Jenssegers\Optimus\Optimus', 'optimus');
		$this->app->alias('Jenssegers\Optimus\Optimus', 'fakeid');
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