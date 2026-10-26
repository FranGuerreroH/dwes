<?php

use App\Importacion\Libro as LibroImportado;
use App\Model\Autor;
use App\Model\Categoria;
use App\Model\Libro;

require_once __DIR__ . '/../vendor/autoload.php';

$autor = new Autor('Frank Herbert');
$dune = new Libro('Dune', $autor);
$hobbit = new LibroImportado('El Hobbit');
$categoria = new Categoria('Ciencia ficción');

echo $dune->ficha() . PHP_EOL;
echo $hobbit->titulo() . PHP_EOL;
echo $categoria->nombre() . PHP_EOL;
