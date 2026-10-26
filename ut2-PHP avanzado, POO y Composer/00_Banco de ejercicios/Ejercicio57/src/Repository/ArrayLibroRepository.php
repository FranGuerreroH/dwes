<?php

namespace App\Repository;

use App\Contract\LibroRepository;
use App\Model\Libro;

class ArrayLibroRepository implements LibroRepository
{
    public function __construct(private array $libros)
    {
    }

    public function todos(): array
    {
        return $this->libros;
    }

    public function buscarPorId(int $id): ?Libro
    {
        foreach ($this->libros as $libro) {
            if ($libro->id() === $id) {
                return $libro;
            }
        }

        return null;
    }
}
