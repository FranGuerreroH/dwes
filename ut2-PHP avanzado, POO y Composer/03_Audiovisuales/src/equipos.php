<?php

declare(strict_types=1);

if (!function_exists('mb_strtolower')) {
    function mb_strtolower(string $string, string $encoding = 'UTF-8'): string {
        return strtolower($string);
    }
}

if (!function_exists('mb_substr')) {
    function mb_substr(string $string, int $start, ?int $length = null, string $encoding = 'UTF-8'): string {
        return substr($string, $start, $length ?? strlen($string));
    }
}

// TODO 1: limpiar espacios con trim y preg_replace (tratamiento UTF-8)
function limpiarEspacios(string $texto): string
{
    return trim(preg_replace('/\s+/u', ' ', $texto));
}

function normalizarBusqueda(string $texto): string
{
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

// TODO 2: obtener categorías con array_column, array_unique y array_values
function obtenerCategorias(array $equipos): array
{
    return array_values(array_unique(array_column($equipos, 'categoria')));
}

function categoriaValida(string $categoria, array $categorias): bool
{
    return $categoria === '' || array_search($categoria, $categorias, true) !== false;
}

// TODO 5: filtrar prestamos activos por equipoId y sumar unidades con array_reduce
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

// TODO 3: filtrar por texto, categoría exacta y disponibles > 0 si $soloDisponibles es true
function filtrarEquipos(
    array $equipos,
    string $texto,
    string $categoria,
    bool $soloDisponibles
): array {
    $textoBusqueda = normalizarBusqueda($texto);

    return array_filter($equipos, function (array $equipo) use ($textoBusqueda, $categoria, $soloDisponibles): bool {
        $coincideTexto = $textoBusqueda === '' || str_contains(normalizarBusqueda($equipo['nombre']), $textoBusqueda);
        $coincideCategoria = $categoria === '' || $equipo['categoria'] === $categoria;
        $coincideDisponibilidad = !$soloDisponibles || $equipo['disponibles'] > 0;

        return $coincideTexto && $coincideCategoria && $coincideDisponibilidad;
    });
}

// TODO 4: ordenar por 'disponibles' o 'nombre', desempagando por id ascendente
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

// TODO 6, 7 y 8: corregir y completar el resumen con array_reduce, array_any y array_all
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

// TODO 9: extraer nombres y aplicar transformarNombres con una closure que use $prefijo y limpiarEspacios
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

// TODO 10: buscar por id con array_find
function buscarPorId(array $equipos, int|string $id): ?array
{
    $idBuscado = normalizarId($id);

    return array_find($equipos, fn(array $equipo): bool => $equipo['id'] === $idBuscado);
}

// TODO 11: devolver "Responsable pendiente" si es null
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