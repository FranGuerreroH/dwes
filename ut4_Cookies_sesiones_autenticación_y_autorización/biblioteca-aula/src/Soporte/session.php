<?php
declare(strict_types=1);

namespace App\Soporte;

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

function flash(){
    $aviso = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $aviso;
}