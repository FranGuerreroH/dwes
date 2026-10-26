<?php

use App\Model\Ejemplar;

require_once __DIR__ . '/../vendor/autoload.php';

$ejemplar01 = new Ejemplar('E-01');
$ejemplar01->prestar();
mostrarEstado($ejemplar01);

$ejemplar01->devolver();
mostrarEstado($ejemplar01);

$ejemplar01->prestar();
mostrarEstado($ejemplar01);

$ejemplar01->marcarPerdido();
mostrarEstado($ejemplar01);

try {
    $ejemplar01->devolver();
} catch (LogicException $exception) {
    echo 'Operación rechazada: ' . $exception->getMessage() . PHP_EOL;
}

$ejemplar02 = new Ejemplar('E-02');
try {
    $ejemplar02->devolver();
} catch (LogicException $exception) {
    echo 'Operación rechazada: ' . $exception->getMessage() . PHP_EOL;
}

echo $ejemplar01->codigo() . ': ' . $ejemplar01->estado()->value . PHP_EOL;
echo $ejemplar02->codigo() . ': ' . $ejemplar02->estado()->value . PHP_EOL;

function mostrarEstado(Ejemplar $ejemplar): void
{
    echo $ejemplar->codigo() . ': ' . $ejemplar->estado()->value . PHP_EOL;
}
