<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

//Повтроно используемый код фреймворка, который абстрагирует обработку входящих Запросов

class Framework
{
    protected $matcher;
    protected $controllerResolver;
    protected $argumentResolver;

    public function __construct(UrlMatcher $matcher, ControllerResolver $controllerResolver, ArgumentResolver $argumentResolver)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            //Метод match() класса UrlMatcher берёт путь запроса и возвращает массив атрибутов
            //Cовпадающий маршрут автоматически хранится в специальном атрибуте _route
            //Импортирует переменные из массива в текущую таблицу символов
            //EXTR_SKIP = Если переменная с таким именем существует, её текущее значение не будет перезаписано
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            return new Response('Файл не найден', 404);
        } catch (\Exception $e) {
            return new Response('Ошибка сервера', 500);
        }
    }
}