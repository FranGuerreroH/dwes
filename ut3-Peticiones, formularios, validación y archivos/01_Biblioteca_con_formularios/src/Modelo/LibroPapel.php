<?php

declare(strict_types=1);

namespace FranGuerrero\Biblioteca\Modelo;

class LibroPapel extends Libro {    

    public function getTipo(): string
    {
        return 'papel';
    }

    public function costeReposicionesCentimos(): int
    {
        return $this->unidades() * $this->paginas() * 5;
    }
}
