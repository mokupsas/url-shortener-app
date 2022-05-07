<?php
declare(strict_types = 1);

namespace UrlShortener;

use Http\HttpRequest;
use Http\HttpResponse;

use UrlShortener\Database\MysqliClass;

require(__DIR__ . '/../vendor/autoload.php');

/*
 *	Http request/response
 */
$request = new HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER, file_get_contents('php://input'));
$response = new HttpResponse();

/*
 *	Database
 */
$db = new MysqliClass('localhost', 'root', '', 'urlshortener');

/*
 *	Dependency injection
 */
$injector = new \Auryn\Injector;
$injector->share($request);
$injector->share($db);


/*
 *	Managing routes
 */
$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
	$routes = require(__DIR__ . '/Routes.php');
	
	foreach($routes as $route)
	{
		$r->addRoute($route[0], $route[1], $route[2]);
	}
});

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri());
switch($routeInfo[0]){
    case \FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case \FastRoute\Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
		/*
		$class = new $className($vars);
		$response->setContent($class->$method());
		*/
		$class = $injector->make($className);
		$content = $class->$method($vars);
		$response->setContent($content);
        break;
}


/*
 *	Giving website output 
 */
foreach($response->getHeaders() as $header)
{
	header($header, false);
}
echo $response->getContent();