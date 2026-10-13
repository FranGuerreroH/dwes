<?php

// Ejercicio 32. Devolver un resultado y mostrarlo
// Crea una clase Libro con propiedades públicas titulo y paginas, inicializadas en el constructor. Añade
// ficha(): string para devolver un texto con el formato Dune - 412 páginas.
// Añade mostrarFicha(): void, que escriba ese texto mediante echo. Crea el libro Dune con 412
// páginas. Guarda el resultado de ficha() en una variable y úsalo en una frase encabezada por Ficha:.
// Después llama a mostrarFicha(). Explica por qué return permite reutilizar el texto y echo lo escribe
// directamente.

final class Libro
{

    public function __construct(public string $titulo, public int $paginas){}

    function ficha(): string
    {
        return $this->titulo . ' - ' . $this->paginas . ' páginas.';
    }

    function mostrarFicha(): void
    {
        echo $this->titulo . ' - ' . $this->paginas . ' páginas.';
    }
}

$libro = new Libro('Dune', 412);

$resultadoDeFicha = $libro->ficha();

echo 'Ficha:' . $resultadoDeFicha . '<br>';

$libro->mostrarFicha();

// Porque la función ficha() devuelve el valor en un string que se puede almacenar en una variable mientras que
// la función mostrarFicha() solo muestra texto por pantalla sin devolver nunca ningún tipo de valor.