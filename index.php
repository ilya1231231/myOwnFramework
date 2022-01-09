<?php
// framework/index.php
$input = isset($_GET['name']) ? $_GET['name'] : 'worddddd';


printf('Hello %s', $input);