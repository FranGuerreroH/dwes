<?php

declare(strict_types=1);

function limpiarEspacios(string $texto): string
{
    return trim(preg_replace('/\s+/u', ' ', $texto));
}

function normalizarBusqueda(string $texto): string
{
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function obtenerCategorias(array $equipos): array
{
    return array_values(array_unique(array_column($equipos, 'categoria')));
}

function categoriaValida(string $categoria, array $categorias): bool
{
    return $categoria === '' || array_search($categoria, $categorias, true) !== false;
}

function unidadesPrestadas(array $prestamos, int $equipoId): int
{
    return array_reduce(
        $prestamos,
        function (int $acumulado, array $prestamo) use ($equipoId): int {
            if ($prestamo['equipoId'] === $equipoId && $prestamo['estado'] === 'activo') {
                return $acumulado + $prestamo['unidades'];
            }
            return $acumulado;
        },
        0
    );
}

// Función facilitada: añade los cálculos a una copia de cada equipo.
function prepararEquipos(array $equipos, array $prestamos): array
{
    return array_map(
        function (array $equipo) use ($prestamos): array {
            $equipo['prestadas'] = unidadesPrestadas($prestamos, $equipo['id']);
            $equipo['disponibles'] = $equipo['unidades'] - $equipo['prestadas'];

            return $equipo;
        },
        $equipos
    );
}

function filtrarEquipos(
    array $equipos,
    string $texto,
    string $categoria,
    bool $soloDisponibles
): array
{
    $textoBusqueda = normalizarBusqueda($texto);

    return array_filter($equipos, function (array $equipo) use ($textoBusqueda, $categoria, $soloDisponibles): bool {
        $coincideTexto = $textoBusqueda === '' || str_contains(normalizarBusqueda($equipo['nombre']), $textoBusqueda);
        $coincideCategoria = $categoria === '' || $equipo['categoria'] === $categoria;
        $coincideDisponibilidad = !$soloDisponibles || $equipo['disponibles'] > 0;

        return $coincideTexto && $coincideCategoria && $coincideDisponibilidad;
    });
}

function ordenarEquipos(array $equipos, string $orden): array
{
    $copia = $equipos;

    usort($copia, function (array $a, array $b) use ($orden): int {
        if ($orden === 'disponibles') {
            $comparacion = $a['disponibles'] <=> $b['disponibles'];
        } else {
            $comparacion = normalizarBusqueda($a['nombre']) <=> normalizarBusqueda($b['nombre']);
        }

        if ($comparacion === 0) {
            return $a['id'] <=> $b['id'];
        }

        return $comparacion;
    });

    return $copia;
}

function resumirEquipos(array $equipos): array
{
    return [
        'cantidad' => count($equipos),
        'unidades' => array_reduce($equipos, fn(int $s, array $a): int => $s + $a['unidades'], 0),
        'prestadas' => array_reduce(
            $equipos,
            fn(int $s, array $a): int => $s + $a['prestadas'],
            0
        ),
        'disponibles' => array_reduce($equipos, fn(int $s, array $a): int => $s + $a['disponibles'], 0),
        'hayAgotados' => array_any($equipos, fn(array $e): bool => $e['disponibles'] === 0),
        'todosDisponibles' => array_all($equipos, fn(array $e): bool => $e['disponibles'] > 0),
    ];
}

// Función facilitada: permite pasar una función como dato.
function transformarNombres(array $nombres, callable $callback): array
{
    return array_map($callback, $nombres);
}

function generarEtiquetas(array $equipos, string $prefijo = 'Equipo: '): array
{
    $nombres = array_column($equipos, 'nombre');

    return transformarNombres($nombres, function (string $nombre) use ($prefijo): string {
        return $prefijo . limpiarEspacios($nombre);
    });
}

// Función facilitada. La entrada web valida el id antes de llamar.
function normalizarId(int|string $id): int
{
    return (int) $id;
}

function buscarPorId(array $equipos, int|string $id): ?array
{
    $idBuscado = normalizarId($id);

    return array_find($equipos, fn(array $equipo): bool => $equipo['id'] === $idBuscado);
}

function responsableVisible(?string $responsable): string
{
    return $responsable ?? 'Responsable pendiente';
}

function inicioNombre(string $nombre): string
{
    return mb_substr(limpiarEspacios($nombre), 0, 3, 'UTF-8');
}

function codigoValido(string $codigo): bool
{
    return preg_match('/^AV-[0-9]{4}-[0-9]{4}$/', $codigo) === 1;
}