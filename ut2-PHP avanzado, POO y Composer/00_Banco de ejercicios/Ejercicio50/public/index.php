<?php

use App\Importacion\Libro as LibroImportado;
use App\Model\Autor;
use App\Model\Libro;

require_once __DIR__ . '/../src/Model/Autor.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Importacion/Libro.php';

$autor = new Autor('Frank Herbert');
$dune = new Libro('Dune', $autor);
$hobbit = new LibroImportado('El Hobbit');

echo $dune->ficha() . PHP_EOL;
echo $hobbit->titulo() . PHP_EOL;
