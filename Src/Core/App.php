<?php
namespace App\Core;

class App
{
	use Handler;

	public function run()
	{
		$this->initRoute();
	}
}