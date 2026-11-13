<?php

declare(strict_types=1);

use App\Contrato\PeliculaRepository;
use App\Modelo\Pelicula;
use App\Servicio\ConsultaPelicula;
use PHPUnit\Event\Test\TestStubCreated;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

final class ConsultaPeliculaTest extends TestCase
{
    // COMPLETAR 11. Película ausente con un stub.
    private function peliculaAusente ():void
    {
        // $peliculaStub = createStub(PeliculaRepository::class);
        //$peliculaStub ->method('buscarPorId')->WillReturn(null);
    
    }


    // COMPLETAR 12. Consulta única del identificador con un mock.

    private function pruebaMock (): void {
        $peliculaValida = new Pelicula( "Dune", "Denis Villeneuve", 155, "ciencia");

        // $mockPelicula = createMock(PeliculaRepository::class);


    }

}
