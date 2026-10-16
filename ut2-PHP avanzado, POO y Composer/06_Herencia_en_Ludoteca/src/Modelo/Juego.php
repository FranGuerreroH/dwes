<?php
declare(strict_types=1);

require_once __DIR__ . '/../Contrato/Prestable.php';
require_once __DIR__ . '/../Compartido/GeneraEtiqueta.php';

// TODO M4. Implementa la base abstracta Juego y las operaciones del préstamo.

// declara Juego como clase abstracta que implementa Prestable e incorpora GeneraEtiqueta con use.

abstract class Juego implements Prestable{    

    use generaEtiqueta;

    private int $id;
    private string $nombre;
    private bool $prestado = false;
    private int $dias = 0;

    public function __construct(int $id, string $nombre)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser mayor que cero.');
        }
        $nombreRecortado = trim($nombre);
        if (empty($nombreRecortado)) {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }
        $this->id = $id;
        $this->nombre = $nombreRecortado;
    }

    public function id(): int{return $this->id;}
    public function nombre(): string{return $this->nombre;}

}