<?php
declare(strict_types=1);

function entrada(array $origen, string $clave, string $defecto = ''): string
{
    if (isset($origen[$clave]) && is_string($origen[$clave])) {
        return $origen[$clave];
    }

    return $defecto;
}

function enteroPositivo(string $valor): int
// TODO F2. Valida antes de convertir; rechaza con InvalidArgumentException.
{
    $entero = filter_var(
        $valor,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    if ($entero === false) {
        throw new InvalidArgumentException(
            "El valor debe ser un entero positivo."
        );
    }

    return $entero;
}

function limpiarEspacios(string $texto): string
{
    return preg_replace('/\s+/u', ' ', trim($texto)) ?? '';
}

function normalizar(string $texto): string
{
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function buscarPorId(array $actividades, int $id): ?Actividad
{
    // TODO F3. Usa array_find con un callback tipado.
    $actividad = array_find($actividades, function (Actividad $actividad) use ($id): bool {
        return $actividad->id() === $id;
    });
    return $actividad? $actividad : null;

}

function filtrarActividades(
    array $actividades, string $texto, string $tipo,
    ?EstadoActividad $estado, bool $soloDisponibles
): array {
    // TODO F4. Combina las cuatro condiciones mediante array_filter.
    return array_filter($actividades, function (Actividad $actividad) use ($texto, $tipo, $estado, $soloDisponibles): bool {
        if ($texto !== '' && strpos(normalizar($actividad->nombre()), normalizar($texto)) === false) {
            return false;
        }

        if ($tipo !== 'gratuita' || $tipo !== 'pago') {
            return false;
        }

        if ($estado !== null && $actividad->estado() !== $estado) {
            return false;
        }

        if ($soloDisponibles && $actividad->estado() === EstadoActividad::Abierta && $actividad->plazasLibres() <= 0) {
            return false;
        }

        return true;
    });
}

function ordenarActividades(array $actividades, string $orden): array
{
    // TODO F5. Ordena una copia con usort y desempata por id.

    $actividadesOrdenadas = $actividades;
    usort($actividadesOrdenadas, function (Actividad $a, Actividad $b) use ($orden): int {
        if ($orden === 'libres') {
            $result = $a->plazasLibres() <=> $b->plazasLibres();
            if ($result === 0) {
                return $a->id() <=> $b->id();
            }
            return $result;
        } else {
            $result = normalizar($a->nombre()) <=> normalizar($b->nombre());
            if ($result === 0) {
                return $a->id() <=> $b->id();
            }
            return $result;
        }
    });

    return $actividadesOrdenadas;
}

function transformarActividades(array $actividades, callable $transformacion): array
{
    return array_map($transformacion, $actividades);
}

function generarEtiquetas(
    array $actividades, string $prefijo = 'Actividad: '
): array
{
    // TODO F6. Usa transformarActividades y una closure con use.
    return transformarActividades($actividades, function (Actividad $actividad) use ($prefijo): string {
                                                        return $actividad->etiqueta($prefijo);});
}

function resumirActividades(array $actividades): array
{
    // TODO F7. Calcula las cinco magnitudes con array_reduce.

return array_reduce($actividades, function (array $acumulador, Actividad $actividad): array {
    $acumulador['cantidad']++;
    $acumulador['capacidad'] += $actividad->capacidad();
    $acumulador['ocupadas'] += $actividad->ocupadas();
    $acumulador['libres'] += $actividad->plazasLibres();
    $acumulador['importe'] += $actividad->importe($actividad->ocupadas());
    return $acumulador;
}, [
    'cantidad' => 0,
    'capacidad' => 0,
    'ocupadas' => 0,
    'libres' => 0,
    'importe' => 0
]);

}

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function euros(int $centimos): string
{
    return number_format($centimos / 100, 2, ',', '.') . ' €';
}
