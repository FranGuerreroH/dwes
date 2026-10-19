<?php

// Ejercicio 33. Identidad y referencias al mismo objeto
// Antes de ejecutar el fragmento, predice el título de cada objeto y el resultado de las dos
// comparaciones. Después compruébalo.

final class Libro
{
 public function __construct(public string $titulo) {}
}

$original = new Libro('Dune');  // titulo = Dune
$alias = $original;  //titulo = Dune
$otro = new Libro('Dune'); // titulo = Dune
$alias->titulo = 'Solaris'; //titulo de $alias y $original = Solaris
echo $original->titulo . PHP_EOL;
echo $otro->titulo . PHP_EOL;
var_dump($original === $alias);
var_dump($original === $otro);

// Explica la diferencia entre asignar un objeto a otra variable y crear una nueva instancia con new.
// Indica cuántos objetos Libro existen en este fragmento.

//RESPUESTA
// Si a una una variable se le asigna otro objeto la dirección de memoria de esa nueva variable va a apuntar
// al mismo lugar que a ese objeto, por lo que los cambios que se le haga a una afectarán a la otra.

// Si se crea una nueva instancia aunque posean los mismos parámetros serán independientes.

// Existen 3 variables libro, pero en memoria solo hay realmente 2 objetos libro.