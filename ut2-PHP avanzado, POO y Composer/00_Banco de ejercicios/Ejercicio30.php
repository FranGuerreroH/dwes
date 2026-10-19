<?php

// Ejercicio 30. Promoción de propiedades y valores por defecto
// Reescribe la clase usando promoción de propiedades en el constructor. Conserva los mismos
// nombres, tipos, visibilidad y valor por defecto.
// final class Libro
// {
//  public string $titulo;
//  public bool $disponible;
//  public function __construct(
//  string $titulo, bool $disponible = true
//  ) {
//  $this->titulo = $titulo;
//  $this->disponible = $disponible;
//  }
// }
// Crea new Libro('Dune') y new Libro('Solaris', false), y muestra sus propiedades. Explica qué
// argumento usa el valor por defecto y qué error produciría new Libro() al omitir el título obligatorio.

final class Libro
{
    public function __construct(
        public string $titulo,
        public bool $disponible = true        
    ){}
}

$libro = new Libro('Dune');
$libro2 = new Libro('Solaris', false);

echo $libro->titulo . ' ' . $libro->disponible;
echo $libro2->titulo . ' ' . $libro2->disponible;

// En el primer libro usa el valor por defecto de disponible porque no se ha introducido