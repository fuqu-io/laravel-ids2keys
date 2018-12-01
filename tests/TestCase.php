<?php

namespace FuquIo\Test;

use Orchestra\Testbench\TestCase as BaseCase;
use FuquIo\LaravelIds2Keys\ServiceProvider;

class TestCase extends BaseCase{
	protected function setUp(){
		parent::setUp();

		$this->loadLaravelMigrations();
	}


	protected function getPackageProviders($app){
		return [ServiceProvider::class];
	}

}