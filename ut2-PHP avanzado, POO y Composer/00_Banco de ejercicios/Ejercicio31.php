<?php

// Completa prestar() y devolver() para cambiar la propiedad disponible del objeto que recibe la
// llamada. Usa $this y métodos con retorno void.
final class Libro
{
 public function __construct(
    public string $titulo,
    public bool $disponible = true,
 ) {}

 public function prestar(): void
 {
    $this->disponible = false;
 }
 public function devolver(): void
 {
    $this->disponible = true;
 }
}
// Crea dos objetos distintos, Dune y Solaris. Presta solo Dune y muestra disponible en ambos.
// Devuelve Dune y vuelve a comprobarlo. Explica por qué cambiar un objeto no cambia el otro.

$libro1 = new Libro('Dune');
$libro2 = new Libro('Solaris');

$libro1->prestar();

echo 'El primer libro ' . $libro1->titulo . ' hay 0' . $libro1->disponible . ' disponibles <br>';
echo 'El segundo libro ' . $libro2->titulo . ' hay 0' . $libro2->disponible . ' disponibles <br>';

$libro1->devolver();

echo 'El primer libro ' . $libro1->titulo . ' hay 0' . $libro1->disponible . ' disponibles <br>';
echo 'El segundo libro ' . $libro2->titulo . ' hay 0' . $libro2->disponible . ' disponibles';

// Cambiar un objeto no modifica al otro porque son objetos independientes que apuntan a diferentes lugares de memoria