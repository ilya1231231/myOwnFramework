<?php
use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;
use Symfony\Component\EventDispatcher;
use Simplex\Framework;

//Контейнер внедрения зависимостей
$sc = new DependencyInjection\ContainerBuilder();
$sc->register('context', Routing\RequestContext::class);
$sc->register('matcher', Routing\Matcher\UrlMatcher::class)
    ->setArguments(array($routes, new Reference('context')))
;
$sc->register('request_stack', HttpFoundation\RequestStack::class);
$sc->register('controller_resolver', HttpKernel\Controller\ControllerResolver::class);
$sc->register('argument_resolver', HttpKernel\Controller\ArgumentResolver::class);

$sc->register('listener.router', HttpKernel\EventListener\RouterListener::class)
    ->setArguments(array(new Reference('matcher'), new Reference('request_stack')))
;
$sc->register('listener.response', HttpKernel\EventListener\ResponseListener::class)
    ->setArguments(array('UTF-8'))
;
$sc->register('listener.exception', HttpKernel\EventListener\ErrorListener::class)
    ->setArguments(array('Calendar\Controller\ErrorController::exceptionAction'))
;
$sc->register('dispatcher', EventDispatcher\EventDispatcher::class)
    ->addMethodCall('addSubscriber', array(new Reference('listener.router')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.response')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.exception')))
;
$sc->register('framework', Framework::class)
    ->setArguments(array(
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ))
;

return $sc;