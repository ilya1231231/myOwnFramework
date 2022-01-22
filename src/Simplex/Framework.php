<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Calendar\Controller\LeapYearController;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

//Повтроно используемый код фреймворка, который абстрагирует обработку входящих Запросов

class Framework
{
    protected $matcher;
    protected $controllerResolver;
    protected $argumentResolver;

    public function __construct(
        UrlMatcherInterface $matcher,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver)
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