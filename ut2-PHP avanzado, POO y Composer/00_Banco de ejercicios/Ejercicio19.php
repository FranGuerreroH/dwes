<?php

$patron = '/^LIB-\d{4}-\d{4}$/';

$res1 = preg_match($patron, 'LIB-2026-0042');
var_dump($res1);

$res2 = preg_match($patron, 'CODIGO-INVALIDO');
var_dump($res2);

$res3 = @preg_match('/[a-z/', 'LIB-2026-0042');
var_dump($res3);

?>