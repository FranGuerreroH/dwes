<?php

declare(strict_types=1);

require_once __DIR__ . '/../Contrato/Prestable.php';
require_once __DIR__ . '/../Compartido/GeneraEtiqueta.php';

// TODO M4. Implementa la base abstracta Juego y las operaciones del préstamo.

// declara Juego como clase abstracta que implementa Prestable e incorpora GeneraEtiqueta con use.

abstract class Juego implements Prestable
{

    use GeneraEtiqueta;

    private int $id;
    private string $nombre;
    private bool $prestado = false;
    private int $dias = 0;

    public function __construct(int $id, string $nombre)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser mayor que cero.');
        }
        $nombreRecortado = trim($nombre);
        if ($nombreRecortado === '') {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }
        $this->id = $id;
        $this->nombre = $nombreRecortado;
    }

    public function id(): int
    {
        return $this->id;
    }
    public function nombre(): string
    {
        return $this->nombre;
    }
    public function prestado(): bool
    {
        return $this->prestado;
    }
    public function dias(): int
    {
        return $this->dias;
    }

    public abstract function plazoMaximo(): int;

    public function ficha(): string
    {
        return $this->etiqueta() . ' · ' . ($this->prestado ? "No Disponible" : 'Disponible') . ' · ' . $this->dias . ' días';
    }


    public function prestar(int $dias): void
    {
        if ($dias < 0) {
            throw new InvalidArgumentException('Los dias no cumplen la condición');
        }
        if ($this->prestado() || $dias() > $this->plazoMaximo()) {
            throw new PrestamoException('El libro no puede ser prestado porque ya está prestado o se excede el plazo máximo');
        }
        $this->prestado = true;
        $this->dias = $dias;
    }

    public function renovar(int $diasExtra): void
    {
        if ($diasExtra <= 0) {
            throw new InvalidArgumentException('Los días extra no cumplen la condición');
        }
        if (!$this->prestado() || $this->dias() + $diasExtra > $this->plazoMaximo()) {
            throw new PrestamoException('El libro no puede ser renovado porque no está prestado o se excede el plazo máximo');
        }
        $this->dias += $diasExtra;
    }

    public function devolver(): void
    {
        if (!$this->prestado()) {
            throw new PrestamoException('El libro no puede ser devuelto porque no se ha prestado');
        }

        $this->prestado = false;
        $this->dias = 0;
    }
}
