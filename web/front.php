<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

function renderTemplate($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}

$request = Request::createFromGlobals();
$response = new Response();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);

//Основываясь на информации, хранящейся в экземпляре "src/app.php" RouteCollection, экземпляр UrlMatcher может совпадать с путями URL
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

try {
    //Метод match() класса UrlMatcher берёт путь запроса и возвращает массив атрибутов
    //Cовпадающий маршрут автоматически хранится в специальном атрибуте _route
    //Импортирует переменные из массива в текущую таблицу символов
    //EXTR_SKIP = Если переменная с таким именем существует, её текущее значение не будет перезаписано

    $request->attributes->add($matcher->match($request->getPathInfo()));
    //Вызывается пользовательская функция из app.php через ключ-"_controller", далее передаются аргументы запроса
    $response = call_user_func($request->attributes->get('_controller'), $request);
} catch (Routing\Exception\ResourceNotFoundException $exeption) {
    $response = new Response('Файл не найден', 404);
} catch (Exception $exeption) {
    $response = new Response('Ошибка сервера', 500);
}

$response->send();