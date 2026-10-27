<?php

use App\Model\Libro;
use App\Model\Revista;

require_once __DIR__ . '/../vendor/autoload.php';

$recursos = [
    new Libro('Dune'),
    new Revista('Ciencia'),
];

echo 'Total de recursos: ' . count($recursos) . PHP_EOL;
foreach ($recursos as $recurso) {
    echo $recurso->tipo() . PHP_EOL;
}
