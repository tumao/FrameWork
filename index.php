<?php 
	require __DIR__."/vendor/autoload.php";

	define ("ROOT_PATH", __DIR__);		// 根目录地址
	define ("APP_PATH", __DIR__."/App");			// 应用的目录地址
	define ("SRC_PATH", __DIR__."/Src");

	// $req = Symfony\Component\HttpFoundation\Request::createFromGlobals();
	// //获取该请求的方法类型
	// echo "Method: ".$req->getMethod()."<br/>";
	// //获取URI的值
	// echo "URI: " . $req->getRequestUri() . "<br/>";
	// //获取a参数的值,第二个参数为当a不存在时的默认值
	// echo "Params: ".$req->get('a','default');
	$app = new \App\App();
	$app->run();
	// var_dump($app);