<?php

declare(strict_types=1);

// TODO M7. Implementa la especialización final de pago y su constructor.

final class ActividadPago extends Actividad
{
    public function __construct(
        int $id,
        string $nombre,
        int $plazasTotales,
        int $plazasReservadas,
        EstadoActividad $estado,
        ?Responsable $responsable,
        private readonly int $precioCentimos
    ) {
        if ($precioCentimos <= 0) {
            throw new InvalidArgumentException('El precio no puede ser negativo.');
        }
        parent::__construct($id, $nombre, $plazasTotales, $plazasReservadas, $estado, $responsable);
    }

    public function tipo(): string
    {
        return 'pago';
    }

    public function importe(int $cantidad): int
    {
        if ($cantidad < 0) {
            throw new InvalidArgumentException('La cantidad no puede ser negativa.');
        }
        return $this->precioCentimos * $cantidad;
    }
}
