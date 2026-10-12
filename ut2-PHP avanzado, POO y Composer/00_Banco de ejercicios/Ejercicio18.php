<?php

$cadena = ' DRÁCULA ';

// Paso 1: trim
$paso1 = trim($cadena);
echo "Paso 1 (trim): '$paso1'\n";

// Paso 2: mb_strtolower
$paso2 = mb_strtolower($paso1, 'UTF-8');
echo "Paso 2 (mb_strtolower): '$paso2'\n";

// Paso 3: mb_strlen
$paso3 = mb_strlen($paso2, 'UTF-8');
echo "Paso 3 (mb_strlen): $paso3\n";

?>