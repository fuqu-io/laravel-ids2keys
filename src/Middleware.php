<?php

namespace FuquIo\LaravelFakeId;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Closure;

/**
 * Class Middleware
 * @package FuquIo\LaravelCors
 */
class Middleware{

	public function __construct(FakeId $fakeId, Route $route){
		$pattern = '/^'. config(ServiceProvider::SHORT_NAME .'.prefix') .'(\\d+)$/u';

		foreach($route->parameters as &$parameter){
			$parameter = preg_replace($pattern, '$1', $parameter, 1, $match);
			if($match){
				$parameter = $fakeId->decode($parameter);
			}
		}
	}


	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next){

		return $next($request);

	}

}
