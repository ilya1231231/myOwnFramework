<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFormGlobals();

$input = $request->get('name', 'WORD');
$response = new Response(printf('Hello %s', htmlspecialchars($input, ENT_QUOTES, 'UTF-8')));
$response->send();

header('Content-type : text/html ; charset=utf-8');

/* htmlspecialchars преобразует симфолы в Html сущности
В режиме ENT_QUOTES преобразуются и двойные, и одиночные кавычки. а в режиме*/
