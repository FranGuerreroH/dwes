<?php

// Ejercicio 34. De Java a PHP
// Traduce esta clase Java a PHP. Mantén sus propiedades públicas, el constructor y el método
// prestar(). Usa la sintaxis de PHP para los tipos, las propiedades y el objeto actual.
// public final class Libro {
//  public String titulo;
//  public boolean disponible;
//  public Libro(String titulo) {
//  this.titulo = titulo;
//  this.disponible = true;
//  }
//  public void prestar() {
//  this.disponible = false;
//  }
// }
// Crea un objeto con el título Dune, muestra disponible, llama a prestar() y vuelve a mostrarla. Señala
// las equivalencias entre this y $this, el punto y ->, y los dos constructores. Explica por qué public
// delante de class no se conserva en PHP.

final class Libro
{
    public function __construct(
        public string $titulo,
        public bool $disponible = true
    ){}

    public function prestar(): void
    {
        $this->disponible = false;
    }
}

$libro = new Libro('Dune');

echo $libro->disponible;

$libro->prestar();

echo $libro->disponible;

