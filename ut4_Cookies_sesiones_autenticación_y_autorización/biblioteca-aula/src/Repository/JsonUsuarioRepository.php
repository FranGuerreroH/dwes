<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Usuario;
use DomainException;

final class JsonUsuarioRepository implements UsuarioRepository
{
    public function __construct(private readonly ArchivoJson $archivo) {}

    public function filaValida(array $f): bool
    {
        foreach (['nombre', 'correo', 'passwordHash', 'rol'] as $clave) {
            if (!is_string($f[$clave] ?? null) || trim($f[$clave]) === '') {
                return false;
            }
        }

        return is_int($f['id'] ?? null) && $f['id'] > 0
            && in_array($f['rol'], ['ROLE_USER', 'ROLE_LIBRARIAN', 'ROLE_ADMIN'], true)
            && filter_var($f['correo'], FILTER_VALIDATE_EMAIL) !== false
            && $f['correo'] === strtolower(trim($f['correo']));
    }

    private function leerFilas(): array
    {
        $filas = $this->archivo->leer();

        $ids = [];
        $correos = [];

        foreach ($filas as $fila) {
            if (!is_array($fila) || !$this->filaValida($fila)
                || in_array($fila['id'], $ids, true)
                || in_array($fila['correo'], $correos, true)) {
                throw new \RuntimeException('Usuario JSON no válido o repetido');
            }
            $ids[] = $fila['id'];
            $correos[] = $fila['correo'];
        }
        return $filas;
    }

    private function hidratar(array $f): Usuario
    {
        return new Usuario($f['id'], $f['nombre'], $f['correo'], $f['passwordHash'], $f['rol']);
    }

    public function buscarPorCorreo(string $email): ?Usuario
    {
        $email = strtolower(trim($email));
        foreach ($this->leerFilas() as $fila) {
            if ($fila['correo'] === $email) {
                return $this->hidratar($fila);
            }
        }
        return null;
    }

    public function buscarPorId(int $id): ?Usuario
    {
        foreach ($this->leerFilas() as $fila) {
            if ($fila['id'] === $id) {
                return $this->hidratar($fila);
            }
        }
        return null;
    }

    public function siguienteId(): int
    {
        $ids = array_column($this->leerFilas(), 'id');
        return $ids === [] ? 1 : max($ids) +1;
    }
    
    public function guardar(Usuario $usuario): void
    {
        $correo = strtolower(trim($usuario->correo));
        $nueva = [
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'correo' => $correo,
            'passwordHash' => $usuario->passwordHash,
            'rol' => $usuario->rol
        ];

        if (!$this->filaValida($nueva)) {
            throw new DomainException('Usuario no válido');
        }

        $filas = $this->leerFilas();
        $posicion = null;

        foreach ($filas as $i => $fila) {
            if ($fila['correo'] === $correo && $fila['id'] !== $usuario->id) {
                throw new DomainException('Correo electrónico repetido');
            }
            if ($fila['id'] === $usuario->id) {
                $posicion = $i;
            }
        }
        if ($posicion === null) {
            $filas[] = $nueva;
        } else {
            $filas[$posicion] = $nueva;
        }
        $this->archivo->escribir($filas);
    }
}