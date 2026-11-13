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
    public function testTitulo(): void {
        $pelicula = new Pelicula( " Dune ", " Denis Villeneuve ", 155, "ciencia");

        assertSame("Dune", trim($pelicula->titulo()));
    }

    public function testDirector(): void {
        $pelicula = new Pelicula( " Dune ", " Denis Villeneuve ", 155, "ciencia");

        assertSame("Denis Villeneuve", trim($pelicula->director()));
    }

    public function testDuracion(): void {
        $pelicula = new Pelicula( " Dune ", " Denis Villeneuve ", 155, "ciencia");

        assertSame(155, $pelicula->duracion());
        assertIsInt($pelicula->duracion());
    }

    public function testFecha():void {
        $pelicula = new Pelicula( " Dune ", " Denis Villeneuve ", 155, "ciencia");

        assertNull($pelicula->fechaEstreno());
    }

}
