<?php

namespace Clase\Alquileres\Modelo;

class AlquilerPatinete extends Alquiler {

 public function modalidad(): string
 {
    return 'patinete';
 }

 public function tarifaDiaria(): int
 {
    return 1000;
 }
    
}