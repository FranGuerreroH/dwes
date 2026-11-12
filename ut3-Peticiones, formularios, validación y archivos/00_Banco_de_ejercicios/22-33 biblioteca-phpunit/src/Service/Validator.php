<?php
declare(strict_types=1);
namespace App\Service;
final class Validator
{
    public function requerido(string $valor,
        string $mensaje): ?string
    {
        return trim($valor) === '' ? $mensaje : null;
    }

    public function validarPortada(int $tamano, string $mime): ?string
    {
        return $tamano < 1 || $tamano > 2 * 1024 * 1024
            || !in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)
            ? 'La portada debe ser JPEG, PNG o WebP y no superar 2 MiB.'
            : null;
    }
}
