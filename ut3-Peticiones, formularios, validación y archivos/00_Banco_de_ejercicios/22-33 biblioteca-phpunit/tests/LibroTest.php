<?php

use App\Model\Libro;

class LibroTest extends PHPUnit\Framework\TestCase {
    public function testConservaTitulo(): void{
        $libro = new Libro ("Dune", "Frank Herbert", 412);
        $this->assertSame("Dune", $libro->Titulo());
    }

    public function testDisponible(): void{
        $libro = new Libro ("Dune", "Frank Herbert", 412);
        $libro->prestar();
        $this->assertSame(false, $libro->estaDisponible());
    }

    public function testPaginas(): void{
        $libro = new Libro ("Dune", "Frank Herbert", 412);
        $this->assertSame(412, $libro->paginas());
        $this->assertEquals(412, $libro->paginas());
    }

    public function testConservaTituloSolaris(): void{
        $libro = new Libro ("Dune", "Frank Herbert", 412);
        $this->assertSame("Solaris", $libro->Titulo());
    }

    public function testPrestarDosVecesLanzaExcepcion(): void {
        $libro = new Libro("Dune", "Frank Herbert", 412);
        $libro->prestar();
        $this->expectException(App\Model\LibroNoDisponibleException::class);
        $libro->prestar(); 
    }

    public function testLibroVacío(): void {
        $libro = new Libro("", "Frank Herbert", 412);
        $this->expectException(InvalidArgumentException::class);
        $libro->Titulo();
    }

    public function testPaginasNegativas(): void {
        $libro = new Libro("Dune", "Frank Herbert", -412);  
        $this->expectException(InvalidArgumentException::class);
        $libro->paginas();
    }

}