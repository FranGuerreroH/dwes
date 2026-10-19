<?php

// Usa la clase Autor del ejercicio anterior. Completa el fragmento para que el constructor de Libro acepte un Autor o null, 
// con null como valor por defecto. 

final class Autor{
    public function __construct( public string $nombre){}
}

final class Libro 
{
    public function __construct( 
    public string $titulo, 
    public ?Autor $autor = null
    ) {} 
} 

$conAutor = new Libro('Dune', new Autor('Frank Herbert')); 
$sinAutor = new Libro('Relato anónimo');

// Consulta el nombre del autor de ambos libros mediante ?->. Muestra Sin autor cuando el resultado sea null usando ??. 
// Explica qué devuelve ?-> cuando la relación existe y cuando vale null.

echo $conAutor->autor?->nombre ?? 'Sin autor' . "\n";
echo $sinAutor->autor?->nombre ?? 'Sin autor' . "\n";

// Cuando la relación existe, ?-> devuelve el valor de la propiedad nombre del objeto Autor. 
// Cuando la relación es null, ?-> devolvería null pero se muestra 'Sin autor' a causa del operador ??.