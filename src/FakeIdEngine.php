<?php
namespace FuquIo\LaravelIds2Keys;

use Jenssegers\Optimus\Optimus;

class FakeIdEngine extends Optimus{
	protected static $mode;
}