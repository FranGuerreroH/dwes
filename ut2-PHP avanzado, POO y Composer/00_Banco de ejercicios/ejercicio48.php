
<?php

trait TieneFechaCreacion
{
    private string $fechaCreacion;

    private function inicializarFechaCreacion(string $fecha): void
    {
        $this->fechaCreacion = $fecha;
    }

    public function fechaCreacion(): string
    {
        return $this->fechaCreacion;
    }

    public function etiquetaCreacion(): string
    {
        return 'Creado el ' . $this->fechaCreacion;
    }
}

class Libro
{
    use TieneFechaCreacion;

    public function __construct(
        private string $titulo,
        string $fecha
    ) {
        $this->inicializarFechaCreacion($fecha);
    }

    public function titulo(): string
    {
        return $this->titulo;
    }
}

class Socio
{
    use TieneFechaCreacion;

    public function __construct(
        private string $nombre,
        string $fecha
    ) {
        $this->inicializarFechaCreacion($fecha);
    }

    public function nombre(): string
    {
        return $this->nombre;
    }
}

$dune = new Libro('Dune', '2026-10-01');
$solaris = new Libro('Solaris', '2026-10-02');
$ana = new Socio('Ana', '2026-10-03');

foreach ([$dune, $solaris] as $libro) {
    echo $libro->titulo() . ' - ' . $libro->fechaCreacion() . PHP_EOL;
}

echo $ana->nombre() . ' - ' . $ana->fechaCreacion() . PHP_EOL;

echo $dune->etiquetaCreacion() . PHP_EOL;
echo $solaris->etiquetaCreacion() . PHP_EOL;
echo $ana->etiquetaCreacion() . PHP_EOL;
