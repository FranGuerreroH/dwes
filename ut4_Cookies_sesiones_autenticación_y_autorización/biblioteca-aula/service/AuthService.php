<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Usuario;
use App\Repository\UsuarioRepository;
use DomainException;

final class AuthService
{

    public function __construct(private UsuarioRepository $usuarios) {}

    public function registrar(string $nombre, string $email, string $clave): Usuario
    {
        $email = strtolower(trim($email));
        if ($this->usuarios->buscarPorCorreo($email) !== null) {
            throw new DomainException('Ya existe un usuario con ese correo electrónico');
        }

        $usuario = new Usuario(
            $this->usuarios->siguienteId(),
            $nombre,
            $email,
            password_hash($clave, PASSWORD_DEFAULT),
            'ROLE_USER'
        );

        $this->usuarios->guardar($usuario);
        return $usuario;
    }

    public function autenticar(string $email, string $clave): ?Usuario {
        $usuario = $this->usuarios->buscarPorCorreo($email);
        if ($usuario === null || !password_verify($clave, $usuario->passwordHash)) {
            return null;
        }
        return $usuario;
    }
}