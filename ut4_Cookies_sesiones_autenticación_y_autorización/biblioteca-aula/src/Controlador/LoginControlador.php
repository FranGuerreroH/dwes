<?php
declare(strict_types=1);

namespace App\Controlador;

use App\Service\AuthService;
use DomainException;
use RuntimeException;

use function App\Soporte\redirigir;
use function App\Soporte\soloMetodos;

final class LoginControlador extends Controlador {
    public function mostrar(): void
    {
        $error = null;
        if (soloMetodos(['GET', 'POST']) === 'POST') {
            $email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
            $clave = $_POST['clave'] ?? null;
            try {
                $auth = new AuthService($this->app['usuarios']);
                $usuario = is_string($clave) && strlen($clave) <= 64 && !str_contains($clave, '\0')
                    ? $auth->autenticar($email, $clave) : null;

                if ($usuario !== null) {
                    if (!session_regenerate_id(true)) {
                        throw new RuntimeException('No se pudo regenerar la sesión');
                    }
                    $_SESSION = ['usuario_id' => $usuario->id];
                    redirigir('cuenta.php');
                }
                http_response_code(400);
                $error = 'credenciales inválidas';
            } catch (DomainException $e) {
                $error = $e->getMessage();
            }
        }
        $this->vista('login', compact('error'));
    }
}