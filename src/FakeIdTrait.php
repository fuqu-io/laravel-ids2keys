<?php
namespace FuquIo\LaravelFakeId;

trait FakeIdTrait{

	public function getKeyAttribute(){

		return 'io'. app(FakeId::class)->encode($this->getKey());
	}

	public function getArrayableAppends(){
		return array_unique(parent::getArrayableAppends() + ['key' => 'key']);
	}

	public function getHidden(){
		return array_unique(parent::getHidden() + ['id' => 'id']);
	}

}