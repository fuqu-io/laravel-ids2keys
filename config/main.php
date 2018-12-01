<?php

$prefix = 'IO';

return [

	/*
	|--------------------------------------------------------------------------
	| FakeIdEngine connection settings
	|--------------------------------------------------------------------------
	| Obviously  based on https://github.com/Propaganistas/Laravel-FakeId
	|
	| Since FakeIdEngine depends on jenssegers/optimus, we need three values:
	| - A large prime number lower than 2147483647
	| - The inverse prime so that (PRIME * INVERSE) & MAXID == 1
	| - A large random integer lower than 2147483647
	|
	| Run the `ids2keys:setup` Artisan command to auto-generate random values.
	|
	*/
	'prime'   => env('FAKEID_PRIME', 961748927),
	'inverse' => env('FAKEID_INVERSE', 1430310975),
	'random'  => env('FAKEID_RANDOM', 620464665),

	'before'  => \Illuminate\Routing\Middleware\SubstituteBindings::class,
	'pattern' => '/^'. $prefix .'(\\d+)$/u',
	'hide_id' => true, // !env('APP_DEBUG')

];
