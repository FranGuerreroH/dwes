<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarVideojuego;

final class HorasTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de los cinco valores de horas.

    #[DataProvider("casosHoras")]

    public function testValidarHoras(string $horas, bool $valido): void
    {
        $datos = self::datosValidos();
        $datos['horas'] = $horas;
        $resultado = validarVideojuego($datos);

        $this->assertSame(!$valido, array_key_exists('horas', $resultado['errores']));
        if ($valido) {
            $this->assertSame((int) $horas, $resultado['datos']['horas']);
            $this->assertIsInt($resultado['datos']['horas']);
        } else {
            $this->assertNull($resultado['datos']);
        }
    }

    public static function casosHoras(): array
    {
        return [
            'horas válidas 1' => ['1', true],
            'horas válidas 300' => ['300', true],
            'horas inválidas 0' => ['0', false],
            'horas inválidas 301' => ['301', false],
            'horas inválidas 12abc' => ['12abc', false],
        ];
    }

    public function testValidarCopia(): void
    {
        $copia = self::datosValidos();
        $copia['horas'] = '0';
        $resultado = validarVideojuego($copia);
        $this->assertSame(['horas' => 'Introduce un entero entre 1 y 300.'], $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }    

    // Proporcionado. Datos válidos sobre los que varías solo horas.
    private static function datosValidos(): array
    {
        return [
            'titulo' => 'Islas de cristal',
            'estudio' => 'Nébula Studio',
            'horas' => '35',
            'genero' => 'aventura',
            'fechaLanzamiento' => '',
        ];
    }
}
