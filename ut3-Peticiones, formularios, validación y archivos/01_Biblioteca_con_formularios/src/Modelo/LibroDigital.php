<?php

declare(strict_types=1);

namespace FranGuerrero\Biblioteca\Modelo;

class LibroDigital extends Libro {
    
  
    public function getTipo(): string
    {
        return 'digital';
    }

    public function costeReposicionesCentimos(): int
    {
        return $this->unidades() * 400;
    }
}
