<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function App\Soporte\inspeccionarCaratula;

final class CaratulaTemporalTest extends TestCase
{
    private ?string $temporal = null;

    // COMPLETAR 10. setUp, prueba de rechazo y tearDown.

    protected function setUp(): void
    {
        $temporal = tempnam(sys_get_temp_dir(), "ut3_");
        if ($temporal === false) {
            throw new RuntimeException('No se pudo crear un archivo temporal.');
        }
        $this->temporal = $temporal;
        file_put_contents($this->temporal, 'Contenido de prueba');
    }


    protected function tearDown(): void
    {
        if ($this->temporal !== null && is_file($this->temporal)) {
            unlink($this->temporal);
        }
        if ($this->temporal !== null) {
            $this->assertFileDoesNotExist($this->temporal);
        }
    }

    // Proporcionado. Representa el temporal como entrada de inspeccionarCaratula.
    private function entradaArchivo(): array
    {
        if ($this->temporal === null || !is_file($this->temporal)) {
            throw new RuntimeException('El temporal de prueba no está preparado.');
        }

        return [
            'caratula' => [
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($this->temporal),
                'tmp_name' => $this->temporal,
            ],
        ];
    }

    public function testRechazaArchivoQueNoEsUnaCaratula(): void
    {
        $resultado = inspeccionarCaratula($this->entradaArchivo());

        $this->assertNull($resultado['archivo']);
        $this->assertNotNull($resultado['error']);
    }
}
