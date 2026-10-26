<?php

namespace App\Service;

use App\Contract\LibroRepository;
use App\Model\Libro;

class CatalogoService
{
    public function __construct(private LibroRepository $libroRepository)
    {
    }

    public function disponibles(): array
    {
        return array_filter(
            $this->libroRepository->todos(),
            static fn (Libro $libro): bool => $libro->disponible()
        );
    }

    public function titulosDisponibles(): array
    {
        return array_map(
            static fn (Libro $libro): string => $libro->titulo(),
            $this->disponibles()
        );
    }
}
