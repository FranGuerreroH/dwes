<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function App\Soporte\validarVideojuego;

final class HorasTest extends TestCase
{
    // COMPLETAR 9. Proveedor y prueba de los cinco valores de horas.

    #[DataProvider("casosHoras")]

    public function testValidarHoras(array $datos, array $erroresEsperados): void
    {
        $resultado = validarVideojuego($datos);
        $this->assertSame($erroresEsperados, $resultado['errores']);
    }

    public static function casosHoras(): array
    {
        return [
            'horas válidas 1' => [array_merge(self::datosValidos(), ['horas' => '1']), []],            
            'horas válidas 300' => [array_merge(self::datosValidos(), ['horas' => '300']), []],
            'horas inválidas 0' => [array_merge(self::datosValidos(), ['horas' => '0']), ['horas' => 'Horas debe ser un número entre 1 y 300.']],
            'horas inválidas 301' => [array_merge(self::datosValidos(), ['horas' => '301']), ['horas' => 'Horas debe ser un número entre 1 y 300.']],
            'horas inválidas 12abc' => [array_merge(self::datosValidos(), ['horas' => '12abc']), ['horas' => 'Horas debe ser un número entre 1 y 300.']],
        ];
    }

public function testValidarCopia(): void
    {
        $copia = self::datosValidos();
        $copia['horas'] = '0';
        $resultado = validarVideojuego($copia);
        $this->assertSame(['horas' => 'Horas debe ser un número entre 1 y 300.'], $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }    

    // Proporcionado. Datos válidos sobre los que varías solo horas.
    private function datosValidos(): array
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
