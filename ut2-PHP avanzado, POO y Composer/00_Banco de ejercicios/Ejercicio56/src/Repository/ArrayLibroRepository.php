<?php

namespace App\Repository;

use App\Contract\LibroRepository;

class ArrayLibroRepository implements LibroRepository
{
    public function __construct(private array $libros)
    {
    }

    public function todos(): array
    {
        return $this->libros;
    }
}
