<?php
declare(strict_types=1);

use App\Service\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PortadaValidatorTest extends TestCase
{
    public static function casosPortada(): array
    {
        return [
            'mínimo de un byte' => [1, 'image/jpeg', true],
            'máximo de dos MiB' => [2 * 1024 * 1024, 'image/jpeg', true],
            'un byte por encima del máximo' => [2 * 1024 * 1024 + 1, 'image/jpeg', false],
            'MIME PNG permitido' => [1, 'image/png', true],
            'MIME de texto no permitido' => [1, 'text/plain', false],
        ];
    }

    #[DataProvider('casosPortada')]
    public function testValidaTamanoYMime(int $tamano, string $mime, bool $valido): void
    {
        $resultado = (new Validator())->validarPortada($tamano, $mime);

        if ($valido) {
            $this->assertNull($resultado);
        } else {
            $this->assertNotNull($resultado);
        }
    }
}
