<?php 
	require __DIR__."/vendor/autoload.php";

	define ("ROOT_PATH", __DIR__);		            // 根目录
	define ("APP_PATH", __DIR__."/App");			// 应用目录
	define ("SRC_PATH", __DIR__."/Src");            // 基础框架目录
	define ("CONF_PATH", __DIR__."/Config");        // 配置文件目录

	$app = new Com\Core\App();
	$app->run();