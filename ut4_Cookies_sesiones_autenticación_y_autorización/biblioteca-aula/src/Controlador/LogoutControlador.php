<?php
declare(strict_types=1);

namespace App\Controlador;

use function App\Soporte\cerrarSesion;

use function App\Soporte\redirigir;

use function App\Soporte\soloMetodos;

final class LogoutControlador extends Controlador {
    public function ejecutar(): void 
    {
        soloMetodos(['POST']);
        $this->exigirUsuario();
        cerrarSesion();
        redirigir('index.php');
    }
}