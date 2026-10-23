<?php

namespace Clase\Alquileres\Modelo;

use AlquileresException;
use InvalidArgumentException;


abstract class Alquiler{

    private readonly int $id;
    private string $cliente;
    private int $dias;
    private EstadoAlquiler $estado;

    public function id():int{
        return $this->id;
    }

    public function cliente():string{
        return $this->cliente;
    }

    public function dias():int{
        return $this->dias;
    }

    public function estado():EstadoAlquiler{
        return $this->estado;
    }


    public function __construct(int $id, string $cliente, int $dias, EstadoAlquiler $estado) {
        if($id < 0){
            throw new InvalidArgumentException('No está permitido un id negativo');
        }
        if(trim($cliente) === ''){
            throw new InvalidArgumentException('El cliente introducido no es válido');
        }
        if($dias <= 0 || $dias < 7){
            throw new InvalidArgumentException('Número de dias fuera del rango permitido');
        }
        if($estado !== $this->estado::Reservado || $estado !== $this->estado::Activo || $estado !== $this->estado::Finalizado){
            throw new InvalidArgumentException('Estado no permitido');
        }
    
        $this->id = $id;
        $this->cliente = trim($cliente);
        $this->dias = $dias;
        $this->estado = $estado;

    }

    public abstract function modalidad():string;
    protected abstract function tarifaDiaria():int;

    public function importe(): int {
       return $this->dias() * $this->tarifaDiaria();
    }

    public function iniciar(): void{
        if($this->estado() !== 'reservado' ) {
            throw new AlquileresException('No disponible');
        }

        $this->estado = $this->estado::Activo;
    } 

    public function finalizar(): void{
        if($this->estado() === 'activo' ){
            throw new AlquileresException('No disponible');
        }
        $this->estado = $this->estado::Finalizado;
    }
    
}