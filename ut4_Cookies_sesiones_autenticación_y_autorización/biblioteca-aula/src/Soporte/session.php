<?php
declare(strict_types=1);

namespace App\Soporte;

use RuntimeException;

function iniciarSesion(): void
{
    session_name('biblioteca');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_start([
        'cookie_path' => '/',
        'cookie_secure' => false,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax'
    ]);
}

function cerrarSesion(): void 
{
    $cookie = session_get_cookie_params();
    $_SESSION = [];
    if (!session_destroy()) {
        throw new RuntimeException('No se pudo cerrar sesión');
    }
    setcookie(session_name(), '', [
        'expires' => time() -3600,
        'path' => $cookie['path'],
        'domain' => $cookie['domain'],
        'secure' => $cookie['secure'],
        'httponly' => $cookie['httponly'],
        'samesite' => $cookie['samesite']
    ]);
}

function flash(){
    $aviso = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $aviso;
}