<?php

namespace App\Service;

use App\Model\Recurso;

class ListadoService
{
    public function lineas(array $recursos): array
    {
        return array_map(
            static fn (Recurso $recurso): string => $recurso->tipo() . ': ' . $recurso->titulo(),
            $recursos
        );
    }
}
