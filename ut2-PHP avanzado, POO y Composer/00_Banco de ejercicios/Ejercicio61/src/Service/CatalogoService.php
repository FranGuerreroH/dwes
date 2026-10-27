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

    public function prestarPorId(int $id): void
    {
        $libro = $this->libroRepository->buscarPorId($id);
        if ($libro === null) {
            throw new InvalidArgumentException('No existe un libro con el id ' . $id . '.');
        }

        $libro->prestar();
    }

    public function devolverPorId(int $id): void
    {
        $libro = $this->libroRepository->buscarPorId($id);
        if ($libro === null) {
            throw new InvalidArgumentException('No existe un libro con el id ' . $id . '.');
        }

        $libro->devolver();
    }

    public function buscarDisponibles(string $texto, int $maximo): array
    {
        if ($maximo < 1) {
            throw new InvalidArgumentException('El máximo de páginas debe ser al menos 1.');
        }

        $textoNormalizado = mb_strtolower(trim($texto), 'UTF-8');
        $libros = array_values(array_filter(
            $this->libroRepository->todos(),
            static fn (Libro $libro): bool => $libro->estaDisponible()
                && $libro->paginas() <= $maximo
                && (
                    $textoNormalizado === ''
                    || mb_strpos(mb_strtolower($libro->titulo(), 'UTF-8'), $textoNormalizado, 0, 'UTF-8') !== false
                )
        ));

        usort(
            $libros,
            static fn (Libro $a, Libro $b): int => $a->paginas() <=> $b->paginas()
        );

        return $libros;
    }
}
