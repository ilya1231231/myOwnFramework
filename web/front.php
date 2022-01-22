<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

//ФРОНТ КОНТРОЛЛЕР
$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
//Основываясь на информации, хранящейся в экземпляре "src/app.php" RouteCollection, экземпляр UrlMatcher может совпадать с путями URL
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

//не забыть использовать Composer dump autoload
//переместили все в отдельный класс
$framework = new Simplex\Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();