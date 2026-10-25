<?php namespace App\Repositorio;

use App\Contrato\RepositorioEnvios;
use App\Modelo\Envio;
use App\Excepcion\EnvioException;
use InvalidArgumentException;

class RepositorioEnviosMemoria implements RepositorioEnvios {
    private array $envios = [];

    public function registrar(Envio $envio): void {
        foreach ($this->envios as $existente) {
            if ($existente->id() === $envio->id()) {
                throw new EnvioException("Ya existe un envío con el ID {$envio->id()}.");
            }
        }
        $this->envios[] = $envio;
    }

    public function todos(): array {
        return $this->envios;
    }

    public function buscar(int $id): ?Envio {
        if ($id <= 0) {
            throw new InvalidArgumentException("El ID debe ser positivo.");
        }
        foreach ($this->envios as $envio) {
            if ($envio->id() === $id) {
                return $envio;
            }
        }
        return null;
    }
}