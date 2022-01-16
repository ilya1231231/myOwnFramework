<?php
//use Symfony\Component\Routing;
////Маршруты url
//$routes = new Routing\RouteCollection();
////массив значений по умолчанию атрибута Routing\Route array('name' => 'World')
//$routes->add('hello', new Routing\Route('/hello/{name}', array('name' => 'World')));
//$routes->add('bye', new Routing\Route('/bye'));
//
//return $routes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

function is_leap_year($year = null)
{
    if (null === $year) {
        $year = date('Y');
    }

    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => function ($request) {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Это високосный год!');
        }
        return new Response('Нет, это не весокосный год');
    }
]));


return $routes;