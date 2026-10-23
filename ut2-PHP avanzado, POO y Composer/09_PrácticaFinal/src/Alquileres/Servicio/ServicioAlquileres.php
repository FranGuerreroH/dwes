<?php

namespace Clase\Alquileres\Servicio;
use Clase\Alquileres\Modelo\EstadoAlquiler;
use Clase\Alquileres\Modelo\Alquiler;



class ServicioAlquileres{

public function __construct(private array $alquileres){}

public function todos():array{
    return $this->alquileres;
}

public function consultar(string $texto = '', ?EstadoAlquiler $estado = null): array {

    $alquileresFiltrados =[]; // Mirar de donde sale el alquiler
    if($this->normalizar($texto) === ''){//no filtrar por texto}; //punto 3.2.3
    if ($estado === null || $estado !== $this->estado::Reservado || $estado !== $this->estado::Activo || $estado !== $this->estado::Finalizado){/*no filtrar por alquiler*/}
   
    return usort($alquileresFiltrados, $this->importe);

}

private function normalizar(string $texto): string {
    return mb_strtolower( trim($texto), 'UTF-8');
}

public function resumir(array $alquileres): array{
    $cantidad = array_reduce($alquileres, function ($alquileres['cantidad']):int{$suma = 0; $suma += $alquileres['cantidad'];}, 0);
    $importe = array_reduce($alquileres, function ($alquileres['importe']):int{$suma = 0; $suma += $alquileres['importe'];}, 0);
    return [
        'cantidad' => $cantidad,
        'importe' = $importe
    ]
}


}