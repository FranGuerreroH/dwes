<?php

declare(strict_types=1);

namespace Alquiler\Equipo\Servicio;

use Alquiler\Equipo\Contrato\EquipoRepository;
use Alquiler\Equipo\Excepcion\EquipoException;
use Alquiler\Equipo\Modelo\{Equipo, EstadoEquipo};

final class InventarioService
{
    public function __construct(private EquipoRepository $repository)
    {
    }

    public function filtrar(
        string $texto = '',
        ?EstadoEquipo $estado = null,
        int $minDisponibles = 0
    ): array {
        $texto = mb_strtolower(trim($texto), 'UTF-8');

        if ($minDisponibles < 0) {
            throw new \InvalidArgumentException('Mínimo negativo');
        }

        $equipos = array_filter(
            $this->repository->todos(),
            fn (Equipo $equipo): bool =>
                ($texto === '' || str_contains($equipo->nombreNormalizado(), $texto))
                && ($estado === null || $equipo->estado()::cases() === $estado)
                && $minDisponibles>0 
        );

        return array_values($equipos);
    }

    public function ordenar(array $equipos): array
    {
        // TODO F2: ordena una copia mediante usort y un callback.
        $ordenados = $equipos;
        usort($ordenados, 
        fn (Equipo $a, Equipo $b) : int => $a->unidades() <=> $b->unidades()
            ?: ($a->tarifaDia() <=> $b->tarifaDia())
            ?: ($a->id() <=> $b->id())
        );

        return $ordenados;

    }

    public function fichas(array $equipos, string $prefijo = 'Equipo: '): array
    {
        // TODO F3: utiliza array_map y una arrow function.
        return array_map(
            fn (Equipo $equipo): string => $equipo->ficha($prefijo),
            $equipos
        );
    }

    public function resumen(array $equipos): array
    {
        // TODO F4: acumula las tres cifras mediante array_reduce.
        return array_reduce(
                        $equipos,
                        function (array $resumen, Equipo $equipo): array {
                            $resumen['unidades'] += $equipo->unidades();
                            $resumen['reservadas'] += $equipo->reservadas();
                            $resumen['valorDisponibleCentimos'] +=
                                $equipo->disponibles() * $equipo->tarifaDia();

                            return $resumen;
                        },
                        [
                            'unidades' => 0,
                            'reservadas' => 0,
                            'valorDisponibleCentimos' => 0
                        ]
    );
    }

    public function presupuestarLotes(
    int $cantidad,
    int $dias,
    int $presupuestoCentimos
): array {
    if ($cantidad <= 0 || $dias <= 0 || $presupuestoCentimos < 0) {
        throw new \InvalidArgumentException('Cantidad, días o presupuesto no válidos');
    }

    $candidatos = array_filter(
        $this->repository->todos(),
        fn (Equipo $equipo): bool =>
            $equipo->estado() === EstadoEquipo::Disponible
            && $equipo->disponibles() >= $cantidad
    );

    $propuestas = array_map(
        fn (Equipo $equipo): array => [
            'id' => $equipo->id(),
            'importeCentimos' => $cantidad * $dias * $equipo->tarifaDia(),
            'disponiblesDespues' => $equipo->disponibles() - $cantidad
        ],
        $candidatos
    );

    $opciones = array_reduce(
        $propuestas,
        function (array $resultado, array $propuesta) use ($presupuestoCentimos): array {
            if ($propuesta['importeCentimos'] <= $presupuestoCentimos) {
                $resultado[] = $propuesta;
            }

            return $resultado;
        },
        []
    );

    usort(
        $opciones,
        fn (array $a, array $b): int =>
            ($a['importeCentimos'] <=> $b['importeCentimos'])
            ?: ($a['id'] <=> $b['id'])
    );

    return $opciones;
}
}