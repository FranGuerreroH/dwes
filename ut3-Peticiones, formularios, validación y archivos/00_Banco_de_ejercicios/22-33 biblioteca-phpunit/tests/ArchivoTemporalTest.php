<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ArchivoTemporalTest extends TestCase
{
    private ?string $archivoTemporal = null;

    public function testEliminaElArchivoTemporalCreadoPorLaPrueba(): void
    {
        $archivo = tempnam(sys_get_temp_dir(), 'biblioteca_');
        $this->assertNotFalse($archivo);
        $this->archivoTemporal = $archivo;
        $this->assertFileExists($this->archivoTemporal);
    }

    protected function tearDown(): void
    {
        if ($this->archivoTemporal !== null && file_exists($this->archivoTemporal)) {
            unlink($this->archivoTemporal);
        }

        if ($this->archivoTemporal !== null) {
            $this->assertFileDoesNotExist($this->archivoTemporal);
        }

        parent::tearDown();
    }
}
