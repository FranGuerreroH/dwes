<?php

function ficha(string $titulo, string $autor): string {
    return "Libro: $titulo, escrito por $autor";
}

$resultado = ficha(autor: 'Frank Herbert', titulo: 'Dune');
echo $resultado . "\n";

?>