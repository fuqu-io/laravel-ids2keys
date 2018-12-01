<?php
namespace FuquIo\LaravelIds2Keys;

trait Id2KeyTrait{

	public function getKeyAttribute(){
		return config(ServiceProvider::SHORT_NAME .'.prefix') . app(FakeIdEngine::class)->encode(parent::getKey());
	}

	public function getArrayableAppends(){
		return array_unique(parent::getArrayableAppends() + ['key' => 'key']);
	}

	public function getHidden(){
		$ret = parent::getHidden();

		if(config(ServiceProvider::SHORT_NAME .'.hide_id')){
			return array_unique( $ret + ['id' => 'id']);
		}


		return $ret;
	}

}