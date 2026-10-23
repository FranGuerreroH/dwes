<?php

namespace Clase\Alquileres\Servicio;

use Clase\Alquileres\Modelo\EstadoAlquiler;
use Clase\Alquileres\Modelo\Alquiler;


class ServicioAlquileres
{

    public function __construct(private array $alquileres) {}

    public function todos(): array
    {
        return $this->alquileres;
    }

    public function consultar(string $texto = '', ?EstadoAlquiler $estado = null): array
    {

        // $alquileresFiltrados =[]; // Mirar de donde sale el alquiler

        // Al filtrar ya con str_contains ya lo hacemos
        // if($this->normalizar($texto) === ''){//no filtrar por texto}; //punto 3.2.3

        // if ($estado === null || $estado !== $this->estado::Reservado || $estado !== $this->estado::Activo || $estado !== $this->estado::Finalizado){/*no filtrar por alquiler*/}

        // return usort($alquileresFiltrados, $this->importe);


        $texto = $this->normalizar($texto);

        $filtro = array_filter(
            $this->todos(),
            fn(Alquiler $a): bool =>
            str_contains(
                $this->normalizar($a->cliente()),
                $texto
            )
                && ($estado === null || $a->estado() === $estado)
        );

        usort(
            $filtro,
            fn(Alquiler $a, Alquiler $b): int => ($a->importe() <=> $b->importe()) === 0
                ? $a->id() <=> $b->id()
                : $a->importe() <=> $b->importe()
        );

        return $filtro;
    }


    // Correcto
    private function normalizar(string $texto): string
    {
        return mb_strtolower(trim($texto), 'UTF-8');
    }

    public function resumir(array $alquileres): array
    {
        // Con un reduce también lo puedes hacer
        // A la función le tendrás que poner los parámetros, no?
        $cantidad = array_reduce($alquileres, function (int $carry, Alquiler $a): int {
            $carry++;
            return $carry;
        }, 0);
        $importe = array_reduce($alquileres, function (int $carry, Alquiler $a): int {
            $carry += $a->importe();
            return $carry;
        }, 0);
        return [
            'cantidad' => $cantidad,
            'importe' => $importe
        ];
    }
}
