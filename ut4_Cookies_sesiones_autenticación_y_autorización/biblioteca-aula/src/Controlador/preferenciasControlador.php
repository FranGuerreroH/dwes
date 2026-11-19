<?php

declare(strict_types=1);

namespace App\Controlador;

use function App\Soporte\redirigir;
use function App\Soporte\soloMetodos;

final class PreferenciasControlador extends Controlador
{
    private const PERMITIDAS = [
        'tema'      => ['claro', 'oscuro'],
        'espaciado' => ['compacto', 'ampliado'],
    ];

    public function guardar(): void
    {
        soloMetodos(['POST']);
        foreach (self::PERMITIDAS as $cookie => $valores) {
            $valor = $_POST[$cookie] ?? null;
            if (in_array($valor, $valores, true)) {
                $this->guardarCookie($cookie, $valor);
                redirigir('index.php');
            }
        }
        http_response_code(400);
        exit('Preferencia no válida');
    }

    private function guardarCookie(string $cookie, string $valor): void
    {
        setcookie($cookie, $valor, [
            'expires' => time() + 30 * 86400,
            'path' => '/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}
