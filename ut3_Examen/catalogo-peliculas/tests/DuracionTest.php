<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarPelicula;

final class DuracionTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de las cinco duraciones.
    #[DataProvider("duraciones")]

    private function duraciones(): array
    {
        return [
            'caso válido 1' => ["1", true],
            'caso válido 2' => ["300", true],
            'caso no válido 1' => ["0", false],
            'caso no válido 2' => ["301", false],
            'caso no válido 3' => ["12abc", false],
        ];
    }

    #[DataProvider('duraciones')]
    public function testDuracion(string $entrada, bool $valida): void
    {
        $post = $this->datosValidos();
        $post['duracion'] = $entrada;

        $resultado = validarPelicula($post);

        $this->assertSame($valida, !isset($resultado['errores']['duracion']));

        if ($valida) {
            $this->assertIsInt($resultado['datos']['duracion']);
            $this->assertSame((int) $entrada, $resultado['datos']['duracion']);
        } else {
            $this->assertNull($resultado['datos']);
        }
    }


    // Proporcionado. Datos válidos sobre los que varías solo duracion.
    private function datosValidos(): array
    {
        return [
            'titulo' => 'Dune',
            'director' => 'Denis Villeneuve',
            'duracion' => '155',
            'genero' => 'ciencia',
            'fechaEstreno' => '',
        ];
    }
}
