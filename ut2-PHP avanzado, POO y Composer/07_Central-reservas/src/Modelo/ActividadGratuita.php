<?php
declare(strict_types=1);

// TODO M7. Implementa la especialización final gratuita.

final class ActividadGratuita extends Actividad{
    public function __construct(
        int $id,
        string $nombre,
        int $plazasTotales,
        int $plazasReservadas,
        EstadoActividad $estado,
        ?Responsable $responsable
    ) {
        parent::__construct($id, $nombre, $plazasTotales, $plazasReservadas, $estado, $responsable);
    }

    public function tipo(): string
    {
        return 'gratuita';
    }

    public function importe($cantidad): int
    {
        return 0;
    }
}