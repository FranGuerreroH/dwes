<?php

use App\Model\Libro;
use App\Model\Revista;
use App\Service\ListadoService;

require_once __DIR__ . '/../vendor/autoload.php';

$recursos = [
    new Libro('Dune'),
    new Revista('Ciencia'),
    new Revista('Historia'),
];

$listado = new ListadoService();
foreach ($listado->lineas($recursos) as $linea) {
    echo $linea . PHP_EOL;
}
