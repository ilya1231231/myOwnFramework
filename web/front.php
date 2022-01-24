<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

$request = Request::createFromGlobals();
$requestStack = new RequestStack();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

//Добавление listner'a кастомных ошибок
$listener = new HttpKernel\EventListener\ErrorListener(
    'Calendar\Controller\ErrorController::exception'
);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher, $requestStack));
$dispatcher->addSubscriber($listener);
$dispatcher->addSubscriber(new Simplex\StringResponseListener());

$framework = new Simplex\Framework($dispatcher, $controllerResolver, $requestStack, $argumentResolver);

$framework = new HttpKernel\HttpCache\HttpCache(
    $framework,
    new HttpKernel\HttpCache\Store(__DIR__.'/../cache')
);

$response = $framework->handle($request);
$response->send();

//require_once __DIR__.'/../vendor/autoload.php';
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing;
//use Symfony\Component\HttpKernel;
//use Symfony\Component\EventDispatcher\EventDispatcher;
//
////ФРОНТ КОНТРОЛЛЕР
//$request = Request::createFromGlobals();
//$routes = include __DIR__.'/../src/app.php';
//
////Для кастомной обработки событий при запросах с приоритетами
//$dispatcher = new EventDispatcher();
//$dispatcher->addSubscriber(new Simplex\ContentLengthListener());
//$dispatcher->addSubscriber(new Simplex\GoogleListener());
//
//$context = new Routing\RequestContext();
////Основываясь на информации, хранящейся в экземпляре "src/app.php" RouteCollection, экземпляр UrlMatcher может совпадать с путями URL
//$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
//
//$controllerResolver = new HttpKernel\Controller\ControllerResolver();
//$argumentResolver = new HttpKernel\Controller\ArgumentResolver();
//
////не забыть использовать Composer dump autoload
////переместили все в отдельный класс
//$framework = new Simplex\Framework($dispatcher, $matcher, $controllerResolver, $argumentResolver);
//$framework = new HttpKernel\HttpCache\HttpCache(
//    $framework,
//    new HttpKernel\HttpCache\Store(__DIR__.'/../cache')
//);
//$response = $framework->handle($request);
//$framework->handle($request)->send();
//
//$response->send();