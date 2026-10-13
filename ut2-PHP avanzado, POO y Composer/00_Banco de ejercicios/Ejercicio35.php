<?php

// Ejercicio 35. Autor y categoría como objetos
// Crea las clases Autor y Categoria, cada una con una propiedad pública nombre de tipo string e
// inicializada en el constructor. Crea Libro con propiedades públicas titulo, autor de tipo Autor y
// categoria de tipo Categoria.
// Construye el autor Frank Herbert y la categoría Ciencia ficción. Usa ambos objetos para crear el
// libro Dune. Muestra el título, el nombre del autor y el nombre de la categoría mediante acceso
// encadenado a sus propiedades. Explica por qué autor contiene un objeto Autor y no una cadena.

final class Autor{
    public function __construct( public string $nombre){}
}

final class Categoria{
    public function __construct( public string $nombre){}
}

final class Libro{
    public function __construct(
        public string $titulo,
        public Autor $autor,
        public Categoria $categoria
    ){}
}

$autor = new Autor("Frank Herbert");
$categoria = new Categoria("Ciencia ficción");
$libro = new Libro("Dune", $autor, $categoria);

echo $libro->titulo . "\n";
echo $libro->autor->nombre . "\n";
echo $libro->categoria->nombre . "\n";  

// El objeto libro creado tiene como una de sus propiedades un objeto Autor, por lo que para acceder al nombre hay que hacerlo
// mediante acceso encadenado a sus propiedades.