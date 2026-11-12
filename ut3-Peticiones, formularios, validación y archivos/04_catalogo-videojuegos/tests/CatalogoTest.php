<?php

declare(strict_types=1);

use App\Modelo\Videojuego;
use PHPUnit\Framework\TestCase;

final class CatalogoTest extends TestCase
{
    // COMPLETAR 8. Creación válida y estado del objeto.
    public function testConservaTitulo(): void
    {
        $videojuego = new Videojuego(' Islas de cristal ', ' Nébula Studio ', 35, 'aventura');

        $this->assertSame('Islas de cristal', $videojuego->titulo());
    }

    public function testConservaEstudio(): void
    {
        $videojuego = new Videojuego(' Islas de cristal ', ' Nébula Studio ', 35, 'aventura');

        $this->assertSame('Nébula Studio', $videojuego->estudio());
    }
    public function testConservaHoras(): void
    {
        $videojuego = new Videojuego(' Islas de cristal ', ' Nébula Studio ', 35, 'aventura');

        $this->assertSame(35, $videojuego->horas());
    }
    public function testConservaFechaLanzamiento(): void
    {
        $videojuego = new Videojuego(' Islas de cristal ', ' Nébula Studio ', 35, 'aventura');

        $this->assertNull($videojuego->fechaLanzamiento());
    }
}
