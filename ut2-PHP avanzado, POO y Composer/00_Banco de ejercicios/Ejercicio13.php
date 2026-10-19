<?php
// Ejercicio 13. array_unique y array_combine
// Elimina géneros repetidos mediante array_unique. Después construye un libro asociativo con
// array_combine a partir de un array de claves y otro de valores. Indica qué requisito deben cumplir
// ambos arrays.

$generos = ['terror', 'fantasía', 'terror', 'aventuras'];

$generosUnicos = array_unique($generos);

$claves = ['titulo', 'paginas', 'genero'];
$valores = ['Dune', 412, 'ciencia ficción'];

$libro = array_combine($claves, $valores);

print_r($generosUnicos);
print_r($libro);

// Para usar array_combine, ambos arrays deben tener el mismo número de elementos.

?>