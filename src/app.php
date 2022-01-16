<?php
use Symfony\Component\Routing;
//Маршруты url
$routes = new Routing\RouteCollection();
//массив значений по умолчанию атрибута Routing\Route array('name' => 'World')
$routes->add('hello', new Routing\Route('/hello/{name}', array('name' => 'World')));
$routes->add('bye', new Routing\Route('/bye'));

return $routes;