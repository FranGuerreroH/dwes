<?php

$texto = 'Desarrollo Web con PHP';

var_dump(str_contains($texto, 'PHP'));
var_dump(strpos($texto, 'PHP'));

$texto2 = 'PHP desde cero';
$pos = strpos($texto2, 'PHP');

if ($pos !== false) {
    echo "Encontrado en posición: $pos\n";
} else {
    echo "No encontrado\n";
}

?>