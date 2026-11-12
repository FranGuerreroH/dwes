<?php

namespace Clase\Alquileres\Modelo;


class AlquilerBicicleta extends Alquiler
{
   public function modalidad(): string
   {
      return 'bicicleta';
   }

   public function tarifaDiaria(): int
   {
      return 500;
   }
}
