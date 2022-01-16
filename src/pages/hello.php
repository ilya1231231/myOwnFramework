Hello <?php
/* htmlspecialchars преобразует симфолы в Html сущности
В режиме ENT_QUOTES преобразуются и двойные, и одиночные кавычки. а в режиме*/
echo htmlspecialchars(isset($name) ? $name : 'World', ENT_QUOTES, 'UTF-8') ?>





