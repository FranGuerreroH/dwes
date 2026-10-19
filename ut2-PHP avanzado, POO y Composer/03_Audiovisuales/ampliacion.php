<?php

declare(strict_types=1);

require_once __DIR__ . '/src/equipos.php';
require_once __DIR__ . '/src/inventario.php';

$equipos = prepararEquipos($equipos, $prestamos);

$disponiblesPorNombre = array_column(
    array_map(
        static fn(array $equipo): array => [
            'nombre' => preg_replace('/\s+/u', ' ', trim($equipo['nombre'])),
            'disponibles' => $equipo['disponibles'],
        ],
        $equipos
    ),
    'disponibles',
    'nombre'
);

$primerAgotado = array_find_key(
    $disponiblesPorNombre,
    static fn(int $unidades): bool => $unidades <= 0
);

// TODO C2: indexar equipos por id y ordenarlos con uasort conservando las claves.
$equiposPorId = array_column($equipos, null, 'id');

uasort($equiposPorId, static function (array $a, array $b): int {
    $comparacion = $a['disponibles'] <=> $b['disponibles'];

    if ($comparacion === 0) {
        return $a['id'] <=> $b['id'];
    }

    return $comparacion;
});