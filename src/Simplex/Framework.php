<?php

namespace Simplex;

use phpDocumentor\Reflection\Type;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\HttpKernel\HttpKernel;


//Повтроно используемый код фреймворка, который абстрагирует обработку входящих Запросов

class Framework extends HttpKernel
{
//    private $dispatcher;
//    protected $matcher;
//    protected $controllerResolver;
//    protected $argumentResolver;
//
//    public function __construct(
//        EventDispatcher $dispatcher,
//        UrlMatcherInterface $matcher,
//        ControllerResolverInterface $controllerResolver,
//        ArgumentResolverInterface $argumentResolver)
//    {
//        $this->dispatcher = $dispatcher;
//        $this->matcher = $matcher;
//        $this->controllerResolver = $controllerResolver;
//        $this->argumentResolver = $argumentResolver;
//    }
//
//    //Кеширование
//    public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
//    {
//        $this->matcher->getContext()->fromRequest($request);
//
//        try {
//            //Метод match() класса UrlMatcher берёт путь запроса и возвращает массив атрибутов
//            //Cовпадающий маршрут автоматически хранится в специальном атрибуте _route
//            //Импортирует переменные из массива в текущую таблицу символов
//            //EXTR_SKIP = Если переменная с таким именем существует, её текущее значение не будет перезаписано
//            $request->attributes->add($this->matcher->match($request->getPathInfo()));
//
//            $controller = $this->controllerResolver->getController($request);
//            $arguments = $this->argumentResolver->getArguments($request, $controller);
//
//            return call_user_func_array($controller, $arguments);
//        } catch (ResourceNotFoundException $e) {
//            $response = new Response('Файл не найден', 404);
//        } catch (\Exception $e) {
//            $response =  new Response('Ошибка сервера', 500);
//        }
//
//        // развернуть событие ответа
//        $this->dispatcher->dispatch(new ResponseEvent($response, $request), 'response');
//
//        return $response;
//
//    }
}