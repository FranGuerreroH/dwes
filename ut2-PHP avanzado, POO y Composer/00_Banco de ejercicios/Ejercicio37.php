<?php
// Ejercicio 37. Validación al construir un objeto
// Completa el constructor para rechazar un título vacío o formado solo por espacios, y un número de páginas menor 
// o igual que cero. Usa trim, una condición con || y throw new InvalidArgumentException. 

final class Libro { 
    public function __construct( 
        public string $titulo, 
        public int $paginas 
        ) { 
        if (trim($titulo) === '' || $paginas <= 0) {
            throw new InvalidArgumentException('Título vacío o número de páginas inválido'); 
            } 
        }
}

// Prueba por separado new Libro('Dune', 412), new Libro(' ', 100), new Libro('Solaris', 0) y new Libro('Solaris', -5). 

$libroValido = new Libro('Dune', 412);
$libroSinTitulo = new Libro(' ', 100);
$libroPaginasCero = new Libro('Solaris', 0);
$libroPaginasNegativas = new Libro('Solaris', -5);

echo $libroValido->titulo . " con " . $libroValido->paginas . " páginas\n";
echo $libroSinTitulo->titulo . " con " . $libroSinTitulo->paginas . " páginas\n";
echo $libroPaginasCero->titulo . " con " . $libroPaginasCero->paginas . " páginas\n";
echo $libroPaginasNegativas->titulo . " con " . $libroPaginasNegativas->paginas . " páginas\n";


// Ejecuta cada caso inválido por separado, porque una excepción sin capturar detiene el script. 



// Explica si new entrega un objeto cuando el constructor lanza la excepción.
// RESPUESTA
// No, cuando el constructor lanza una excepción new no entrega el objeto y el script se detiene a menos que la excepción sea capturada
// Lo que le permite seguir.

// Razona si validar al construir impide que otro código asigne después 0 a la propiedad pública paginas. 
// RESPUESTA
// No, validar al construir solo asegura que el objeto se cree con un estado válido, 
// pero no impide que otro código modifique la propiedad.


// Diferencia validar el estado inicial de controlar todos los cambios posteriores.
// RESPUESTA
// Validar el estado inicial asegura que el objeto se cree con datos válidos, mientras que
// controlar todos los cambios posteriores implica implementar  otrosmecanismos 
// para garantizar que las propiedades del objeto sigan siendo válidas.