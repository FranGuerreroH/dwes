<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Autor.php';
require_once __DIR__ . '/../src/Categoria.php';
require_once __DIR__ . '/../src/Libro.php';
require_once __DIR__ . '/../src/datos.php';

// Fase 4: convierte los registros de $datos en objetos Libro.
$libros = [];
foreach ($datos as $registro) {
    $autor = $registro['autor'] === null ? null : new Autor($registro['autor']);
    $categoria = new Categoria($registro['categoria']);
    $libros[] = new Libro(
        // Datos del registro, objeto Autor o null y Categoria.
        $registro['id'],
        $registro['titulo'],
        $registro['paginas'],
        $autor,
        $categoria,
        $registro['disponible']
    );
}

// Fase 5: realiza aquí las comprobaciones de préstamos e identidad.
// Añade textos a $mensajes; la vista los mostrará debajo del catálogo.
// Termina devolviendo Dune para conservar el estado inicial del catálogo.
$dune = $libros[0];
$otro = $libros[2];

$mensajes[] = $dune->ficha();
$mensajes[] = $otro->ficha();

$dune->prestar();
$dune->devolver();

$alias = $dune;
$alias->prestar();

$alias === $dune ? $mensajes[] = 'alias y dune son el mismo objeto' : $mensajes[] = 'alias y dune son objetos distintos';

$otroDune = new Libro($dune->id, $dune->titulo, $dune->paginas, $dune->autor, $dune->categoria, $dune->disponible);
$otroDune === $dune ? $mensajes[] = 'otroDune y dune son el mismo objeto' : $mensajes[] = 'otroDune y dune son objetos distintos';
$dune->devolver();

// Lectura del formulario facilitada. La búsqueda conserva el texto escrito.
$entrada = $_GET['q'] ?? '';
$entradaBusqueda = is_string($entrada) ? $entrada : '';
$soloDisponibles = isset($_GET['disponibles']);
$ordenEntrada = $_GET['orden'] ?? 'paginas';
$orden = is_string($ordenEntrada)
    && in_array($ordenEntrada, ['paginas', 'titulo'], true)
    ? $ordenEntrada : 'paginas';

// Fase 6.1: normaliza la búsqueda y filtra con array_filter.
$busqueda = strtolower(trim($entradaBusqueda)); //mb_strtolower(trim($entradaBusqueda), 'UTF-8'); EN CASA NO ME FUNCIONA

$visibles = array_filter(
    $libros,
    fn(Libro $libro): bool =>
    str_contains(mb_strtolower($libro->titulo, 'UTF-8'), $busqueda) &&
        (!$soloDisponibles || $libro->disponible),
);

// Fase 6.2: ordena $visibles mediante usort y <=>.

usort($visibles, function ($libro1, $libro2) use ($orden) {
    if ($orden === 'paginas') {
        return $libro1->paginas <=> $libro2->paginas;
    } else {
        return $libro1->titulo <=> $libro2->titulo;
    }
});

// Fase 6.3: resumen del catálogo completo, antes de filtrar.
// Completa disponibles con array_filter y paginas con array_reduce.
$resumen = ['total' => count($libros), 'disponibles' => count(array_filter($libros, function ($libro) {
    return $libro->disponible;
})), 'paginas' => array_reduce($libros, function ($acumulador, $libro) {
    return $acumulador + $libro->paginas;
}, 0)];

// Fase 6.3: crea las fichas de los libros visibles con array_map.
$etiquetas = array_map(function ($libro) {
    return $libro->ficha();
}, $visibles);

$libro30 = array_find($libros, function ($libro) {
    return $libro->id === 30;
});

$mensajes[] = 'Buscar id 30: ' . ($encontrado?->titulo ?? 'Libro no encontrado');

// Fase 6.3: busca los ids 30 y 999 con array_find y añade mensajes.

$libro999 = array_find($libros, function ($libro) {
    return $libro->id === 999;
});

$mensajes[] = 'Buscar id 999: ' . ($noEncontrado?->titulo ?? 'Libro no encontrado');


require __DIR__ . '/../vista/catalogo.php';

/* <?= e($libro->autor?->nombre ?? 'Sin autor') ?>*/
// 1. Explica qué parte obtiene el dato del objeto y qué parte permite escribirlo como texto en HTML.

// Respuesta: La parte `$libro->autor?->nombre` obtiene el nombre nombre del objeto, 
// la función `e()` es la que se encarga de escapar el texto para que pueda ser escrito de manera segura 
// en HTML, evitando problemas con caracteres especiales.

// 2. Comprueba que ficha() devuelve texto y que es la vista, no el método, la que decide cómo presentarlo.

// Respuesta: La función `ficha()` devuelve un string con la información del libro