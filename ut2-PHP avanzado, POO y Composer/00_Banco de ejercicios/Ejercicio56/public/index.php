<?php

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;

require_once __DIR__ . '/../vendor/autoload.php';

$libros = [
    new Libro(10, 'Dune', true),
    new Libro(20, 'Solaris', false),
    new Libro(30, 'Drácula', true),
];

$catalogo = new CatalogoService(new ArrayLibroRepository($libros));
foreach ($catalogo->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

$catalogoVacio = new CatalogoService(new ArrayLibroRepository([]));
$titulosDisponibles = $catalogoVacio->titulosDisponibles();
if ($titulosDisponibles === []) {
    echo 'Sin libros disponibles' . PHP_EOL;
}
