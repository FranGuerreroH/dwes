<?php
// Ejercicio 4. array_filter
// Dado un catálogo de libros en arrays, obtén solo los disponibles mediante array_filter y una arrow
// function. Comprueba qué ocurre con las claves originales del array.

$catalogo = [
    ["titulo" => "El Quijote", "autor" => "Miguel de Cervantes", "genero" => "Novela", "disponible" => false],
    ["titulo" => "Cien años de soledad", "autor" => "Gabriel García Márquez", "genero" => "Realismo mágico", "disponible" => true],
    ["titulo" => "1984", "autor" => "George Orwell", "genero" => "Ciencia ficción", "disponible" => false],
    ["titulo" => "Fahrenheit 451", "autor" => "Ray Bradbury", "genero" => "Ciencia ficción", "disponible" => true],
    ["titulo" => "Crimen y castigo", "autor" => "Fiódor Dostoyevski", "genero" => "Novela", "disponible" => false],
    ["titulo" => "Dune", "autor" => "Frank Herbert", "genero" => "Ciencia ficción", "disponible" => true]
];

$disponibles = array_filter($catalogo, fn (array $libro): bool => $libro['disponible'] === true);

function leerLibros(array $disponibles):void{
foreach($disponibles as $libro)
    {echo $libro['titulo'] ;}
}

leerLibros($disponibles);

//Se conservan las claves originales que en este caso son 1,3 y 5

?>