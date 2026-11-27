<?php

declare(strict_types=1);

namespace App\Controlador;

use App\Controlador\Controlador;

use function App\Soporte\soloMetodos;

final class CuentaControlador extends Controlador 
{
    public function mostrar(): void 
    {
        soloMetodos(['GET']);
        $usuario = $this->exigirUsuario();
        $this->vista('cuenta', compact('usuario'));
    }
}