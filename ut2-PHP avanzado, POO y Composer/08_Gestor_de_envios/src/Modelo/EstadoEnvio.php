<?php

namespace App\Modelo;

enum EstadoEnvio: string {
    case Pendiente = 'pendiente';
    case Enviado = 'enviado';
    case Entregado = 'entregado';
    case Cancelado = 'cancelado';
}