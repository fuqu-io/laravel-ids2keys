<?php

namespace FuquIo\LaravelIds2Keys;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Closure;

/**
 * Class Middleware
 * @package FuquIo\LaravelCors
 */
class Middleware{

	private $fakeId;

	public function __construct(FakeIdEngine $fakeId, Route $route){
		$this->fakeId = $fakeId;
		$pattern = config(ServiceProvider::SHORT_NAME .'.pattern');

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
		$pattern = config(ServiceProvider::SHORT_NAME .'.pattern');

		$inputs = $request->all();
		foreach($inputs as &$input){
			$input = preg_replace($pattern, '$1', $input, 1, $match);
			if($match){
				$input = $this->fakeId->decode($input);
			}
		}
		$request->request->replace($inputs);

		return $next($request);

	}

}
