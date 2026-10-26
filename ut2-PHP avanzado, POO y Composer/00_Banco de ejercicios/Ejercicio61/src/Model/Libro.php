<?php

namespace App\Model;

use App\Exception\LibroNoDisponibleException;
use InvalidArgumentException;

class Libro
{
    public function __construct(
        private int $id,
        private string $titulo,
        private int $paginas,
        private bool $disponible
    ) {
        if ($this->id <= 0) {
            throw new InvalidArgumentException('El id del libro debe ser positivo.');
        }

        if (trim($this->titulo) === '') {
            throw new InvalidArgumentException('El título del libro no puede estar vacío.');
        }

        if ($this->paginas <= 0) {
            throw new InvalidArgumentException('El número de páginas debe ser positivo.');
        }
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function paginas(): int
    {
        return $this->paginas;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException(
                'El libro "' . $this->titulo . '" no está disponible para préstamo.'
            );
        }

        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}
