<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Usuario;

interface UsuarioRepository
{
    public function buscarPorId(int $id): ?Usuario;
    public function buscarPorCorreo(string $correo): ?Usuario;
    public function siguienteId(): int;
    public function guardar(Usuario $usuario): void;
}