<?php

declare(strict_types=1);

use App\Contrato\VideojuegoRepository;
use App\Modelo\Videojuego;
use App\Servicio\ConsultaVideojuego;
use PHPUnit\Framework\TestCase;

final class ConsultaVideojuegoTest extends TestCase
{
    public function testVideojuegoAusente(): void
    {
        $stubVideojuegoRepository = $this->createStub(VideojuegoRepository::class);
        $stubVideojuegoRepository
            ->method('buscarPorId')
            ->willReturn(null);

        $consultaVideojuego = new ConsultaVideojuego($stubVideojuegoRepository);

        $this->expectException(OutOfBoundsException::class);
        $consultaVideojuego->obtener(99);
    }

    public function testConsultaUnaVez(): void
    {
        $videojuego = new Videojuego('The Legend of Zelda', 'Nintendo', 20, 'aventura');

        $mockVideojuegoRepository = $this->createMock(VideojuegoRepository::class);
        $mockVideojuegoRepository
            ->expects($this->once())
            ->method('buscarPorId')
            ->with(7)
            ->willReturn($videojuego);

        $consultaVideojuego = new ConsultaVideojuego($mockVideojuegoRepository);

        $this->assertSame($videojuego, $consultaVideojuego->obtener(7));
    }
}