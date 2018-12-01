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
		$this->decodeIfEncoded($route->parameters);
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


		$inputs = $request->all();
		$this->decodeIfEncoded($inputs);
		$request->request->replace($inputs);

		return $next($request);

	}

	private function decodeIfEncoded(array &$arr){
		$pattern = config(ServiceProvider::SHORT_NAME .'.pattern');

		foreach($arr as &$input){
			if(is_string($input)){
				$input = preg_replace($pattern, '$1', $input, 1, $match);
				if($match){
					$input = $this->fakeId->decode($input);
				}
			}elseif(is_array($input)){
				$this->decodeIfEncoded($input);
			}
		}
	}

}
