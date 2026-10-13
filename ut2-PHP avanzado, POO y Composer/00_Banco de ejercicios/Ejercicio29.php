<?php

// Lee el fragmento e indica qué propiedades están inicializadas. Explica qué ocurriría si se leyera titulo
// inmediatamente después de crear el objeto.

final class Libro
{
    public string $titulo;
    public int $paginas = 0;
    public bool $disponible = true;

    public function __construct(string $titulo, int $paginas, bool $disponible){
        $this->titulo = $titulo;
        $this->paginas = $paginas;
        $this->disponible = $disponible;
    }
}

$libro = new Libro('Solaris', 216, true);

echo $libro->titulo;
echo $libro->paginas;
echo $libro->disponible;




// Asigna 'Solaris' a titulo y 216 a paginas antes de leerlas. Comprueba que final permite crear el objeto
// y modificar sus propiedades públicas. Explica por qué una clase hija que use extends Libro sería
// rechazada, sin incorporarla al archivo que ejecutas.

//RESPUESTA:
// Están inicializadas $paginas y $disponibles con 0 y true respectivamente
// Al añadir final a la clase libro hace que sea imposible el llevar a cabo la herencia

?>