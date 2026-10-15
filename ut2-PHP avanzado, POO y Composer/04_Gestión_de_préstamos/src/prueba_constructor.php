<?php
declare(strict_types=1);

require_once __DIR__ . '/Autor.php';
require_once __DIR__ . '/Categoria.php';
require_once __DIR__ . '/Libro.php';


// Fase 2.1: crea aquí un Autor y una Categoria y muestra sus nombres.

// $autor = new Autor('Frank Herbert');
// $categoria = new Categoria('Ciencia ficción');

// Fase 2.2: cuando completes Libro.php, añade su require_once arriba.
// Después crea los dos libros y muestra su disponibilidad.

// $libro = new Libro(10, 'Dune', 412, $autor, $categoria);
// $libro2 = new Libro(10, 'Dune', 412, $autor, $categoria, false);
// echo $autor->nombre . "\n";
// echo $categoria->nombre . "\n";
// echo $libro->disponible ? 'true' . "\n": 'false' . "\n";
// echo $libro2->disponible ? 'true' . "\n": 'false' . "\n";

// Fase 3.2: sustituye las pruebas anteriores por un Libro construido
// con las variables $titulo y $paginas. Muestra ambas propiedades.

$autor = new Autor('Frank Herbert');
$categoria = new Categoria('Ciencia ficción');
$titulo = '';
$paginas = 100;
$libro = new Libro(10, $titulo, $paginas, $autor, $categoria);

echo $libro->paginas . "\n";
echo $libro->titulo . "\n";


