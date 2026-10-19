<?php
declare(strict_types=1);

final class Categoria
{
    public string $nombre;
    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
    }
    // Fase 2: propiedad pública nombre y constructor.
}
