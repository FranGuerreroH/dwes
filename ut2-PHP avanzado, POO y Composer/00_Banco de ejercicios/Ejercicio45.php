
<?php

enum EstadoEjemplar: string
{
    case Disponible = 'disponible';
    case Prestado = 'prestado';
    case Perdido = 'perdido';
}

class Ejemplar
{
    public function __construct(
        private string $codigo,
        private EstadoEjemplar $estado = EstadoEjemplar::Disponible
    ) {
    }

    public function codigo(): string
    {
        return $this->codigo;
    }

    public function estado(): EstadoEjemplar
    {
        return $this->estado;
    }

    public function cambiarEstado(EstadoEjemplar $estado): void
    {
        $this->estado = $estado;
    }
}

$ejemplares = [
    new Ejemplar('E-01'),
    new Ejemplar('E-02', EstadoEjemplar::Prestado),
    new Ejemplar('E-03', EstadoEjemplar::Perdido),
];

foreach ($ejemplares as $ejemplar) {
    echo $ejemplar->codigo() . ' - ' .
        $ejemplar->estado()->name . ' - ' .
        $ejemplar->estado()->value . PHP_EOL;
}

$disponibles = array_filter(
    $ejemplares,
    fn(Ejemplar $ejemplar): bool =>
        $ejemplar->estado() === EstadoEjemplar::Disponible
);

foreach ($disponibles as $ejemplar) {
    echo 'Disponible: ' . $ejemplar->codigo() . PHP_EOL;
}

$e01 = $ejemplares[0];

foreach (['prestado', 'perdido', 'reservado'] as $entrada) {
    $estado = EstadoEjemplar::tryFrom($entrada);

    if ($estado === null) {
        echo 'Estado no válido' . PHP_EOL;
    } else {
        $e01->cambiarEstado($estado);
    }

    echo $e01->codigo() . ' - ' . $e01->estado()->value . PHP_EOL;
}

foreach (EstadoEjemplar::cases() as $estado) {
    echo $estado->value . PHP_EOL;
}

$recuento = array_fill_keys(
    array_map(fn(EstadoEjemplar $estado): string => $estado->value, EstadoEjemplar::cases()),
    0
);

foreach ($ejemplares as $ejemplar) {
    $recuento[$ejemplar->estado()->value]++;
}

foreach ($recuento as $estado => $cantidad) {
    echo $estado . ': ' . $cantidad . PHP_EOL;
}
