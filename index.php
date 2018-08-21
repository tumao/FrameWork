<?php 
	require __DIR__."/vendor/autoload.php";

	define ("ROOT_PATH", __DIR__);		// 根目录地址
	define ("APP_PATH", __DIR__."/App");			// 应用的目录地址
	define ("SRC_PATH", __DIR__."/Src");

	require __DIR__."/Src/Core/App.php";
	require __DIR__."/Src/Core/Handler.php";
	$app = new Com\Core\App();
	$app->run();