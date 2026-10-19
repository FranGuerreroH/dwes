<?php
// Ejercicio 8. array_find
// Busca con array_find el primer libro cuyo id sea 3. Muestra su título si existe y contempla
// correctamente el caso en que la función devuelva null. Explica la diferencia principal respecto a
// array_filter.

$libros = [
    ['id' => 1, 'titulo' => 'Dune'],
    ['id' => 2, 'titulo' => '1984'],
    ['id' => 3, 'titulo' => 'It']
];

$libro = array_find(
    $libros,
    fn($libro) => $libro['id'] === 3
);

if ($libro !== null) {
    echo $libro['titulo'];
} else {
    echo 'Libro no encontrado';
}

// array_find devuelve EL PRIMER ELEMENTO que cumple la condición o null si no encuentra ninguno, mientras que 
// array_filter devuelve TODOS los elementos que cumplen la condición.

?>
