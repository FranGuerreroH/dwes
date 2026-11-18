<?php
declare(strict_types=1);

namespace App\Controlador;

abstract class Controlador
{
    public function __construct(protected array $app) {}

    protected function vista(string $nombre, array $datos = []): void
    {
        extract($datos, EXTR_SKIP);
        require dirname(__DIR__, 2) . '/vistas/cabecera.php';
        require dirname(__DIR__, 2) . '/vistas/' . $nombre . '.php';
        require dirname(__DIR__, 2) . '/vistas/pie.php';
    }
}
