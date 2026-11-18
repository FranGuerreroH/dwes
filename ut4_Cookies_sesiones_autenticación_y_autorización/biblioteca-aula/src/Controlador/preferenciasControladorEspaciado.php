<?php

declare(strict_types=1);

namespace App\Controlador;
use function App\Soporte\redirigir;

final class PreferenciasControladorEspaciado extends Controlador {
    
    public function guardar(): void {
        $espaciado = $_POST['espaciado'] ?? null;
        if (in_array($espaciado, ['compacto', 'ampliado'], true)) {
            $this->guardarCookie('espaciado', $espaciado);
            redirigir('index.php');
        }
        http_response_code(400);
        exit;
    }

    private function guardarCookie(string $cookie, string $valor) {
        setcookie($cookie, $valor, [
            'expires' => time() + 30 *86400,
            'path' => '/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}