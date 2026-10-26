<?php

use App\Exception\LibroNoDisponibleException;
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

echo 'Disponibles antes del préstamo:' . PHP_EOL;
foreach ($catalogo->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

$catalogo->prestarPorId(10);

echo 'Disponibles después del préstamo:' . PHP_EOL;
foreach ($catalogo->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

echo '¿Dune sigue disponible? ' . ($libros[0]->estaDisponible() ? 'true' : 'false') . PHP_EOL;

try {
    $catalogo->prestarPorId(10);
} catch (LibroNoDisponibleException $exception) {
    echo $exception->getMessage() . PHP_EOL;
}

try {
    $catalogo->prestarPorId(99);
} catch (\InvalidArgumentException $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
