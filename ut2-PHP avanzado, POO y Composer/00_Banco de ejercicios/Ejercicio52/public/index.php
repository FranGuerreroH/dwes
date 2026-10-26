<?php

use App\Model\Libro;
use App\Model\Personas\Autor;
use App\Service\CatalogoService;

require_once __DIR__ . '/../vendor/autoload.php';

$dune = new Libro('Dune', new Autor('Frank Herbert'));
$solaris = new Libro('Solaris', new Autor('Stanislaw Lem'));
$catalogo = new CatalogoService([$dune, $solaris]);

foreach ($catalogo->fichas() as $ficha) {
    echo $ficha . PHP_EOL;
}
