<?php
// Busca 'terror' dentro de un array de géneros usando array_search con comparación estricta. Escribe la
// condición correcta para distinguir entre una clave 0 válida y el valor false de 'no encontrado'.

$generos = ['terror', 'ciencia ficción', 'fantasía'];

$posicion = array_search('terror', $generos, true);

if ($posicion !== false) {
    echo "Encontrado en la posición $posicion";
} else {
    echo 'No encontrado';
}

// Se utiliza !== false porque la posición 0 es válida y no debe confundirse con false.

?>