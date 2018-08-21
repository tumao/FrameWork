<?php
namespace Com\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Odan\Middleware\Dispatcher\HttpFoundationSprinter;

//trait Handler
trait Handler
{
	 /**
     * Init route
     * @return $this|mixed
     */
    public function initRoute()
    {
        $routes = require SRC_PATH . "/routes.php";

        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) use ($routes)
        {
            foreach ($routes as $route) 
            {
                $methods = array_map("strtoupper", (array)$route[0]);
                $r->addRoute($methods, $route[1], $route[2]);
            }
        });

        $request = Request::createFromGlobals();
        $method = $request->getMethod();
        $uri = rawurldecode($request->getRequestUri());
        if (false !== $pos = strpos($uri, '?')) 
        {
            $uri = substr($uri, 0, $pos);
        }

        $response = Response::create();

        //注入了Logger之后可以去除注释
        //App::Logger()->addInfo(
        //    sprintf(
        //        'Accepted request %s %s',
        //        $request->getMethod(),
        //        $request->getUri()
        //    ),
        //    [
        //        $request->getQueryString()
        //    ]
        //);
        $routeInfo = $dispatcher->dispatch($method, $uri);
        switch ($routeInfo[0]) 
        {

            case \FastRoute\Dispatcher::NOT_FOUND:
                return $response->setStatusCode('404')->setContent("404 Not Found")->send();
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                return $response->setStatusCode('405')->setContent("405 Method Not Allowed")->send();
                break;
            case \FastRoute\Dispatcher::FOUND:

                try 
                {

                    $sprinter = new HttpFoundationSprinter();
                    $response = $sprinter->run($request, $response, []);

                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    if (is_string($handler) && (strpos($handler, '@'))) 
                    {
                        $ret = $this->callHandler($handler, $vars, $request, $response);
                    }
                    else
                    {
                        $ret = call_user_func($handler, $request, $response, $vars);
                    }
                } 
                catch (\Exception $e) 
                {
                    return $response->setStatusCode("500")->setContent($e->getMessage())->send();
                }

                if ($ret instanceof Response) 
                {
                    return $ret;
                }
                if (is_array($ret)) 
                {
                    $response->headers->set("Content-Type", "application/json;charset=utf-8");
                    return $response->setContent(json_encode($ret))->send();
                }
                return $response->setContent($ret)->send();
                break;
        }
    }

    /**
     * @param $handler
     * @param $vars
     * @param $request
     * @param $response
     * @return mixed
     */
    public function callHandler($handler, $vars, $request, $response)
    {
        if (is_string($handler) && (strpos($handler, '@'))) 
        {
            list($class, $method) = explode('@', $handler);
            $class = ucfirst($class) . "Controller";
            return (new $class())->$method($request, $response, $vars);
        }

        return call_user_func($handler, $request, $response, $vars);
    }
}