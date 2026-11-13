<?php

declare(strict_types=1);

use App\Modelo\Pelicula;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsInt;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.
    public function testTitulo(): void
    {
        $pelicula = new Pelicula(" Dune ", " Denis Villeneuve ", 155, "ciencia");

        assertSame("Dune", $pelicula->titulo());
        assertSame("Denis Villeneuve", $pelicula->director());
        assertSame(155, $pelicula->duracion());
        assertNull($pelicula->fechaEstreno());
    }
}
