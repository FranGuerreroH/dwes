<?php

namespace App\Service;

use App\Contract\LibroRepository;
use App\Model\Libro;
use InvalidArgumentException;

class CatalogoService
{
    public function __construct(private LibroRepository $libroRepository)
    {
    }

    public function disponibles(): array
    {
        return array_filter(
            $this->libroRepository->todos(),
            static fn (Libro $libro): bool => $libro->estaDisponible()
        );
    }

    public function titulosDisponibles(): array
    {
        return array_map(
            static fn (Libro $libro): string => $libro->titulo(),
            $this->disponibles()
        );
    }

    public function prestarPorId(int $id): void
    {
        $libro = $this->libroRepository->buscarPorId($id);
        if ($libro === null) {
            throw new InvalidArgumentException('No existe un libro con el id ' . $id . '.');
        }

        $libro->prestar();
    }
}
