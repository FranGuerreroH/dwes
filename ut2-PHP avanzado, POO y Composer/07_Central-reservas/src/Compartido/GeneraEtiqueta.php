<?php

declare(strict_types=1);

// TODO M3. Declara el trait GeneraEtiqueta y su método etiqueta.

trait GeneraEtiqueta
{
    public function etiqueta(string $prefijo = ''): string
    {
        // No me queda muy claro por qué limitas a 50 caracteres.
        $nombre = preg_replace('/\s+/u', ' ', trim($this->nombre())) ?? '';
        return $prefijo . $this->id() . ' · ' . $nombre;
    }
}
