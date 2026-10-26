<?php

namespace App\Model;

use App\Exception\LibroNoDisponibleException;

class Libro
{
    public function __construct(
        private string $titulo,
        private bool $disponible
    ) {
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException(
                'el libro "' . $this->titulo . '" ya está prestado'
            );
        }

        $this->disponible = false;
    }
}
