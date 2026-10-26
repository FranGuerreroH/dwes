<?php

namespace App\Model;

use LogicException;

class Ejemplar
{
    public function __construct(
        private string $codigo,
        private EstadoEjemplar $estado = EstadoEjemplar::Disponible
    ) {
    }

    public function codigo(): string
    {
        return $this->codigo;
    }

    public function estado(): EstadoEjemplar
    {
        return $this->estado;
    }

    public function prestar(): void
    {
        if ($this->estado !== EstadoEjemplar::Disponible) {
            throw new LogicException('Solo se puede prestar un ejemplar disponible.');
        }

        $this->estado = EstadoEjemplar::Prestado;
    }

    public function devolver(): void
    {
        if ($this->estado !== EstadoEjemplar::Prestado) {
            throw new LogicException('Solo se puede devolver un ejemplar prestado.');
        }

        $this->estado = EstadoEjemplar::Disponible;
    }

    public function marcarPerdido(): void
    {
        if (
            $this->estado !== EstadoEjemplar::Disponible
            && $this->estado !== EstadoEjemplar::Prestado
        ) {
            throw new LogicException('El ejemplar no puede cambiar de estado.');
        }

        $this->estado = EstadoEjemplar::Perdido;
    }
}
