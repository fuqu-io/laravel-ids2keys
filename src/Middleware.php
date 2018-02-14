<?php

namespace FuquIo\LaravelPackage;

use Illuminate\Http\Request;
use Closure;

/**
 * Class Middleware
 * @package FuquIo\LaravelCors
 */
class Middleware{
	/**
	 * Handle an incoming API requests and permitting certain domains.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next){
		//

		return $next($request);
	}
}
