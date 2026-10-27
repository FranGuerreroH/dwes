<?php

use App\Exception\LibroNoDisponibleException;
use App\Exception\OperacionBibliotecaException;
use App\Model\Libro;

require_once __DIR__ . '/../vendor/autoload.php';

$libros = [
    10 => new Libro('Dune', true),
    20 => new Libro('Solaris', false),
];

function prestarPorId(array $libros, int $id): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('el id debe ser positivo');
    }

    if (!array_key_exists($id, $libros)) {
        throw new OperacionBibliotecaException('no existe un libro con ese id');
    }

    $libros[$id]->prestar();
}

foreach ([10, 10, 20, 99, 0] as $id) {
    try {
        prestarPorId($libros, $id);
        echo 'Préstamo realizado.' . PHP_EOL;
    } catch (LibroNoDisponibleException $exception) {
        echo 'Operación ' . $id . ' rechazada: ' . $exception->getMessage() . '.' . PHP_EOL;
    } catch (OperacionBibliotecaException $exception) {
        echo 'Operación ' . $id . ' rechazada: ' . $exception->getMessage() . '.' . PHP_EOL;
    } catch (InvalidArgumentException $exception) {
        echo 'Operación ' . $id . ' rechazada: ' . $exception->getMessage() . '.' . PHP_EOL;
    } finally {
        echo 'Fin de operación ' . $id . PHP_EOL;
    }
}

echo 'Dune disponible: ' . ($libros[10]->estaDisponible() ? 'sí' : 'no') . PHP_EOL;
echo 'Solaris disponible: ' . ($libros[20]->estaDisponible() ? 'sí' : 'no') . PHP_EOL;
