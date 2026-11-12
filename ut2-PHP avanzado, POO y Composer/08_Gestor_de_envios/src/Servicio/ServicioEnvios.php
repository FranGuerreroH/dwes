<?php

namespace App\Servicio;

use App\Contrato\RepositorioEnvios;
use App\Modelo\Envio;
use App\Modelo\EstadoEnvio;
use App\Excepcion\EnvioException;
use InvalidArgumentException;

class ServicioEnvios
{
    private RepositorioEnvios $repositorio;

    public function __construct(RepositorioEnvios $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    private function obtener(int $id): Envio
    {
        $envio = $this->repositorio->buscar($id);
        if ($envio === null) {
            throw new EnvioException("No se encontró el envío con ID {$id}.");
        }
        return $envio;
    }

    public function enviar(int $id): void
    {
        $envio = $this->obtener($id);
        $envio->enviar();
    }

    public function entregar(int $id): void
    {
        $envio = $this->obtener($id);
        $envio->entregar();
    }

    public function cancelar(int $id): void
    {
        $envio = $this->obtener($id);
        $envio->cancelar();
    }

    private static function normalizar(string $texto): string
    {
        $limpio = trim($texto);
        $reducido = preg_replace('/\s+/', ' ', $limpio);
        return mb_strtolower($reducido, 'UTF-8');
    }

    public function consultar(string $texto = '', ?string $modalidad = null, ?EstadoEnvio $estado = null, string $orden = 'precio'): array
    {
        if ($modalidad !== null && $modalidad !== 'normal' && $modalidad !== 'urgente') {
            throw new InvalidArgumentException("Modalidad desconocida.");
        }
        if ($orden !== 'precio' && $orden !== 'peso') {
            throw new InvalidArgumentException("Criterio de orden desconocido.");
        }

        $todos = $this->repositorio->todos();
        if ($todos === [])
            return [];

        if (empty($todos)) {
            throw new InvalidArgumentException("El repositorio está vacío.");
        }

        $textoNormalizado = $texto !== '' ? self::normalizar($texto) : '';

        $filtrados = array_filter($todos, function (Envio $envio) use ($textoNormalizado, $modalidad, $estado) {
            if ($textoNormalizado !== '') {
                $clienteNorm = self::normalizar($envio->cliente());
                if (mb_strpos($clienteNorm, $textoNormalizado, 0, 'UTF-8') === false) {
                    return false;
                }
            }
            if ($modalidad !== null && $envio->modalidad() !== $modalidad) {
                return false;
            }
            if ($estado !== null && $envio->estado() !== $estado) {
                return false;
            }
            return true;
        });

        usort($filtrados, function (Envio $a, Envio $b) use ($orden) {
            if ($orden === 'precio') {
                $comp = $a->tarifa() <=> $b->tarifa();
            } else {
                $comp = $a->peso() <=> $b->peso();
            }
            if ($comp === 0) {
                return $a->id() <=> $b->id();
            }
            return $comp;
        });

        return array_values($filtrados);
    }

    public function etiquetas(array $envios): array
    {
        return array_map(function (Envio $envio) {
            return sprintf(
                "ID: %d | Cliente: %s | Modalidad: %s | Estado: %s | Tarifa: %d céntimos (%.2f €)",
                $envio->id(),
                $envio->cliente(),
                $envio->modalidad(),
                $envio->estado()->value,
                $envio->tarifa(),
                $envio->tarifa() / 100
            );
        }, $envios);
    }

    public function resumir(array $envios): array
    {
        $inicial = [
            'cantidad' => 0,
            'peso' => 0,
            'importeTotal' => 0,
            'importeActivo' => 0,
            'pendiente' => 0,
            'enviado' => 0,
            'entregado' => 0,
            'cancelado' => 0
        ];

        return array_reduce($envios, function (array $acum, Envio $envio) {
            $acum['cantidad']++;
            $acum['peso'] += $envio->peso();
            $tarifa = $envio->tarifa();
            $acum['importeTotal'] += $tarifa;
            if ($envio->estado() !== EstadoEnvio::Cancelado) {
                $acum['importeActivo'] += $tarifa;
            }
            $estadoStr = $envio->estado()->value;
            if (isset($acum[$estadoStr])) {
                $acum[$estadoStr]++;
            }
            return $acum;
        }, $inicial);
    }
}
