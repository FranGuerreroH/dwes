<?php

namespace Clase\Alquileres\Modelo;

use AlquileresException;
use InvalidArgumentException;


abstract class Alquiler
{
    // Mejor promoción
    public function __construct(private readonly int $id, private string $cliente, private int $dias, private EstadoAlquiler $estado)
    {
        if ($id < 0) {
            throw new InvalidArgumentException('No está permitido un id negativo');
        }
        if (trim($cliente) === '') {
            throw new InvalidArgumentException('El cliente introducido no es válido');
        }
        // Mayor que 7 -0,25
        if ($dias <= 0 || $dias > 7) {
            throw new InvalidArgumentException('Número de dias fuera del rango permitido');
        }
        // Lo de los estados no lo entiendo
        $this->cliente = trim($cliente);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function cliente(): string
    {
        return $this->cliente;
    }

    public function dias(): int
    {
        return $this->dias;
    }

    public function estado(): EstadoAlquiler
    {
        return $this->estado;
    }

    public abstract function modalidad(): string;
    protected abstract function tarifaDiaria(): int;

    public function importe(): int
    {
        return $this->dias() * $this->tarifaDiaria();
    }

    public function iniciar(): void
    {
        // Comparas un EstadoAlquiler con un string en lugar de con EstadoAlquiler -0,25
        if ($this->estado() !== EstadoAlquiler::Reservado) {
            throw new AlquileresException('No disponible');
        }
        $this->estado = EstadoAlquiler::Activo;
    }

    public function finalizar(): void
    {
        // Igual que arriba -0,25
        if ($this->estado() === EstadoAlquiler::Activo) {
            throw new AlquileresException('No disponible');
        }
        $this->estado = EstadoAlquiler::Finalizado;
    }
}
