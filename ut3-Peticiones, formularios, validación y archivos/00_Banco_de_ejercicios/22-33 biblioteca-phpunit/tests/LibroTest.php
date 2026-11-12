<?php

use App\Model\Libro;
use App\Model\LibroNoDisponibleException;
use InvalidArgumentException;

class LibroTest extends PHPUnit\Framework\TestCase
{
    protected Libro $libro;

    protected function setUp(): void
    {
        $this->libro = new Libro('Dune', 'Frank Herbert', 412);
    }

    public function testLibroNuevoEstaDisponible(): void
    {
        $this->assertTrue($this->libro->estaDisponible());
    }

    public function testLibroDejaDeEstarDisponibleAlPrestarlo(): void
    {
        $this->libro->prestar();

        $this->assertFalse($this->libro->estaDisponible());
    }

    public function testConservaTitulo(): void
    {
        $this->assertSame('Dune', $this->libro->titulo());
    }

    public function testPaginas(): void
    {
        $this->assertSame(412, $this->libro->paginas());
    }

    public function testPrestarDosVecesLanzaExcepcion(): void
    {
        $this->libro->prestar();

        $this->expectException(LibroNoDisponibleException::class);
        $this->libro->prestar();
    }

    public function testTituloVacioLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Libro('', 'Frank Herbert', 412);
    }

    public function testPaginasNegativasLanzanExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Libro('Dune', 'Frank Herbert', -412);
    }
}