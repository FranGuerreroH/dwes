<?php

declare(strict_types=1);

// TODO M6. Implementa la clase abstracta Actividad, sus reglas y las operaciones final.

abstract class Actividad implements Reservable
{
    use GeneraEtiqueta;

    public function __construct(
        private readonly int $id,
        private readonly string $nombre,
        private readonly int $capacidad,
        private int $ocupadas,
        private readonly EstadoActividad $estado,
        private readonly ?Responsable $responsable

    ) {
        if ($this->id <= 0) {
            throw new InvalidArgumentException('El id debe ser un entero positivo.');
        }
        if (trim($this->nombre) === '') {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }
        if ($this->capacidad <= 0) {
            throw new InvalidArgumentException('La capacidad debe ser un entero positivo.');
        }
        if ($this->ocupadas < 0 || $this->ocupadas > $this->capacidad) {
            throw new InvalidArgumentException('El número de plazas ocupadas no es válido.');
        }
    }

    public function id(): int
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function capacidad(): int
    {
        return $this->capacidad;
    }

    public function ocupadas(): int
    {
        return $this->ocupadas;
    }

    public function estado(): EstadoActividad
    {
        return $this->estado;
    }

    public function responsable(): ?Responsable
    {
        return $this->responsable;
    }

    public function plazasLibres(): int
    {
        return $this->capacidad - $this->ocupadas;
    }

    public abstract function tipo(): string;
    public abstract function importe(int $cantidad): int;

    public final function reservar(int $cantidad): void
    {
        if ($cantidad <= 0) {
            throw new InvalidArgumentException();
        }

        if ($this->estado === EstadoActividad::Cerrada) {
            throw new ReservaException('La actividad no está abierta para reservas.');
        }

        if ($this->plazasLibres() < $cantidad) {
            throw new PlazasInsuficientesException('No hay suficientes plazas disponibles.');
        }

        $this->ocupadas += $cantidad;
    }

    public final function cancelar(int $cantidad): void
    {
        if ($cantidad <= 0) {
            throw new InvalidArgumentException('La cantidad indicada no es válida');
        }

        if ($cantidad > $this->ocupadas) {
            throw new ReservaException('No se pueden cancelar más plazas de las ocupadas.');
        }

        $this->ocupadas -= $cantidad;
    }
}
