<?php
declare(strict_types=1);

use App\Service\LibroFormService;
use App\Service\Validator;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LibroFormServiceTest extends TestCase
{
    public static function casosPaginas(): array
    {
        return [
            'mínimo permitido' => ['1', true],
            'máximo permitido' => ['3000', true],
            'cero' => ['0', false],
            'por encima del máximo' => ['3001', false],
            'texto añadido' => ['12abc', false],
            'decimal' => ['12.5', false],
            'array' => [['412'], false],
        ];
    }

    #[DataProvider('casosPaginas')]
    public function testPaginasAceptaSoloValoresDelRango(mixed $paginas, bool $esperado): void
    {
        $resultado = $this->servicio()->procesar($this->entrada(['paginas' => $paginas]));
        $hayError = array_key_exists('paginas', $resultado['errores']);

        $this->assertSame(!$esperado, $hayError);
        if ($esperado) {
            $this->assertSame((int) $paginas, $resultado['datos']['paginas']);
        } else {
            $this->assertNull($resultado['datos']);
        }
    }

    public function testProcesaYDevuelveLaFichaCompleta(): void
    {
        $resultado = $this->servicio()->procesar($this->entrada([
            'titulo' => ' Dune ',
        ]));

        $this->assertSame([
            'titulo' => 'Dune',
            'autor' => 'Frank Herbert',
            'paginas' => '412',
            'genero' => 'ciencia',
            'fechaAlta' => '',
        ], $resultado['valores']);
        $this->assertSame([], $resultado['errores']);
        $this->assertSame([
            'titulo' => 'Dune',
            'autor' => 'Frank Herbert',
            'paginas' => 412,
            'genero' => 'ciencia',
            'fechaAlta' => null,
        ], $resultado['datos']);
    }

    public function testAceptaFechaValida(): void
    {
        $resultado = $this->servicio()->procesar($this->entrada([
            'fechaAlta' => '2026-10-24',
        ]));

        $this->assertSame([], $resultado['errores']);
        $this->assertInstanceOf(DateTimeImmutable::class, $resultado['datos']['fechaAlta']);
        $this->assertSame('2026-10-24', $resultado['datos']['fechaAlta']->format('Y-m-d'));
    }

    public function testRechazaFechaImposible(): void
    {
        $resultado = $this->servicio()->procesar($this->entrada([
            'fechaAlta' => '2026-02-31',
        ]));

        $this->assertArrayHasKey('fechaAlta', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }

    public function testAceptaTituloDeCientoVeinteCaracteres(): void
    {
        $resultado = $this->servicio()->procesar($this->entrada([
            'titulo' => str_repeat('a', 120),
        ]));

        $this->assertArrayNotHasKey('titulo', $resultado['errores']);
        $this->assertSame(120, mb_strlen($resultado['datos']['titulo'], 'UTF-8'));
    }

    public function testRechazaTituloDeCientoVeintiunCaracteres(): void
    {
        $resultado = $this->servicio()->procesar($this->entrada([
            'titulo' => str_repeat('a', 121),
        ]));

        $this->assertArrayHasKey('titulo', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }

    public function testTituloNoTextoConservaErrorDeTipo(): void
    {
        $resultado = $this->servicio()->procesar($this->entrada([
            'titulo' => ['Dune'],
        ]));

        $this->assertSame('Debe ser texto.', $resultado['errores']['titulo']);
        $this->assertNull($resultado['datos']);
    }

    public function testRechazaGeneroNoPermitido(): void
    {
        $resultado = $this->servicio()->procesar($this->entrada([
            'genero' => 'aventura',
        ]));

        $this->assertArrayHasKey('genero', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }

    private function servicio(): LibroFormService
    {
        return new LibroFormService(new Validator());
    }

    private function entrada(array $cambios = []): array
    {
        return array_replace([
            'titulo' => 'Dune',
            'autor' => 'Frank Herbert',
            'paginas' => '412',
            'genero' => 'ciencia',
            'fechaAlta' => '',
        ], $cambios);
    }
}
