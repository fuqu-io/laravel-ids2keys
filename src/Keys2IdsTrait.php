<?php
namespace FuquIo\LaravelIds2Keys;

trait Keys2IdsTrait{

	public function preProcessInputs($arr){
		$pattern = '/^'. config(ServiceProvider::SHORT_NAME .'.prefix') .'(\\d+)$/u';

		foreach($arr as &$item){
			$item = preg_replace($pattern, '$1', $item, 1, $match);
			if($match){
				$item = app(FakeIdEngine::class)->decode($item);
			}
		}

		return $arr;
	}

}