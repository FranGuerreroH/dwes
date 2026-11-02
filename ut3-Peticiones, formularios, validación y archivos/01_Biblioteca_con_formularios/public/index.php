<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use FranGuerrero\Biblioteca\Servicio\BibliotecaService;

$libros = require dirname(__DIR__) . '/datos/libros.php';

$biblioteca = new BibliotecaService($libros);

$q = isset($_GET['q']) && is_string($_GET['q']) ? $_GET['q'] : '';
$genero = isset($_GET['genero']) && is_string($_GET['genero']) ? $_GET['genero'] : '';
$tipo = isset($_GET['tipo']) && is_string($_GET['tipo']) ? $_GET['tipo'] : '';
$soloDestacados = array_key_exists('destacados', $_GET);

$librosFiltrados = $biblioteca->filtrar($q, $genero, $tipo, $soloDestacados);
$filas = $biblioteca->filas($librosFiltrados);
$resumen = $biblioteca->resumen($librosFiltrados);

require dirname(__DIR__) . '/src/Vistas/catalogo.php';
