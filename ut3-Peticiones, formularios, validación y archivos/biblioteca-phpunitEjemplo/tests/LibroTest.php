<?php

use App\Model\Libro;

class LibroTest extends PHPUnit\Framework\TestCase {
    public function testConservaTitulo(): void{
        $libro = new Libro ("Dune", "Frank Herbert", 412);
        $this->assertSame("Dune", $libro->Titulo());
    }
}