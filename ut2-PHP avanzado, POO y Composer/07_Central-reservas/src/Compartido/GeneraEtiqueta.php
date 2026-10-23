<?php
declare(strict_types=1);

// TODO M3. Declara el trait GeneraEtiqueta y su método etiqueta.

trait GeneraEtiqueta
{
    public function etiqueta(string $prefijo = ''): string
    {
        return mb_substr(($prefijo . $this->id() . "·" . $this->nombre()), 0, 50);
    }
}