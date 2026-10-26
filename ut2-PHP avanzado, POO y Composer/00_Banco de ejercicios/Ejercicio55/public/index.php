<?php

use App\Model\Libro;
use App\Service\CatalogoService;

require_once __DIR__ . '/../vendor/autoload.php';

$libros = [
    new Libro('Dune'),
    new Libro('Solaris'),
];
$catalogo = new CatalogoService();

foreach ($libros as $libro) {
    echo $catalogo->mostrar($libro) . PHP_EOL;
}
