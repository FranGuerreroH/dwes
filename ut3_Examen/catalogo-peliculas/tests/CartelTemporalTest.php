<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function App\Soporte\inspeccionarCartel;

final class CartelTemporalTest extends TestCase
{
    private ?string $temporal = null;

    // COMPLETAR 10. setUp, prueba de rechazo y tearDown.
    protected function setUp ():void
    {
        self::$temporal = tempnam(sys_get_temp_dir(), "ut3_");
        if (!self::$temporal){
            throw new RuntimeException();
        }
        self::$temporal = $this->temporal;
        file_put_contents(self::$temporal, 'contenido');        
    }

    protected function tearDown (): void {
        if (self::$temporal !== null && !is_file(self::$temporal)){
            unlink(self::$temporal);
        }
    }


    // Proporcionado. Representa el temporal como entrada de inspeccionarCartel.
    private function entradaArchivo(): array
    {
        if ($this->temporal === null || !is_file($this->temporal)) {
            throw new RuntimeException('El temporal de prueba no está preparado.');
        }

        return [
            'cartel' => [
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($this->temporal),
                'tmp_name' => $this->temporal,
            ],
        ];
    }
}
