
<?php
//$input = $request->get('name', 'WORLD');
//$response = new Response(printf('Hello %s', htmlspecialchars($input, ENT_QUOTES, 'UTF-8')));
//$response->setContent("");

/* htmlspecialchars преобразует симфолы в Html сущности
В режиме ENT_QUOTES преобразуются и двойные, и одиночные кавычки. а в режиме*/


$name = $request->attributes->get('name', 'World') ?>
Hello <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>


