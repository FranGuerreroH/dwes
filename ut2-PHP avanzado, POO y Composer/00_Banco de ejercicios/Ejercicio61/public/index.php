<?php

use App\Exception\LibroNoDisponibleException;
use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;

require_once __DIR__ . '/../vendor/autoload.php';

$libros = [
    new Libro(10, 'Dune', 412, true),
    new Libro(20, 'Solaris', 216, false),
    new Libro(30, 'Drácula', 418, true),
    new Libro(40, 'El Hobbit', 310, true),
];

$catalogo = new CatalogoService(new ArrayLibroRepository($libros));
$mostrarCatalogo = static function (array $libros): void {
    if ($libros === []) {
        echo 'Sin resultados' . PHP_EOL;
        return;
    }

    foreach ($libros as $libro) {
        echo $libro->titulo() . PHP_EOL;
    }
};

echo "Catálogo disponible:\n";
$mostrarCatalogo($catalogo->buscarDisponibles('', 500));

echo "Búsqueda DRÁ:\n";
$mostrarCatalogo($catalogo->buscarDisponibles(' DRÁ ', 500));

echo "Búsqueda xyz:\n";
$mostrarCatalogo($catalogo->buscarDisponibles('xyz', 500));

$catalogo->prestarPorId(10);
try {
    $catalogo->prestarPorId(10);
} catch (LibroNoDisponibleException $exception) {
    echo 'Segundo préstamo rechazado: ' . $exception->getMessage() . PHP_EOL;
}

echo "Después de prestar Dune:\n";
$mostrarCatalogo($catalogo->buscarDisponibles('', 500));

$catalogo->devolverPorId(10);
echo "Catálogo tras devolver Dune:\n";
$mostrarCatalogo($catalogo->buscarDisponibles('', 500));

try {
    $catalogo->devolverPorId(99);
} catch (InvalidArgumentException $exception) {
    echo 'Devolución rechazada: ' . $exception->getMessage() . PHP_EOL;
}

try {
    $catalogo->buscarDisponibles('', 0);
} catch (InvalidArgumentException $exception) {
    echo 'Búsqueda rechazada: ' . $exception->getMessage() . PHP_EOL;
}
