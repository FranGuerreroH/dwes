<?php

$codigo = 'LIB-2026-0042';
$prefijo = substr($codigo, 0, 3);
$secuencia = substr($codigo, 9);

echo "$prefijo\n";
echo "$secuencia\n";

$obra = 'Drácula';
$tres_primeros = mb_substr($obra, 0, 3, 'UTF-8');
echo "$tres_primeros\n";

?>