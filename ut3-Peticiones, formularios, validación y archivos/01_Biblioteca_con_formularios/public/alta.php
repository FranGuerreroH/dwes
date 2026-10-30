<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use FranGuerrero\Biblioteca\Modelo\LibroDigital;
use FranGuerrero\Biblioteca\Modelo\LibroPapel;
use FranGuerrero\Biblioteca\Servicio\BibliotecaService;

$libros = require dirname(__DIR__) . '/datos/libros.php';
$biblioteca = new BibliotecaService($libros);

$valores = [
    'tipo' => '',
    'titulo' => '',
    'autor' => '',
    'paginas' => '',
    'genero' => '',
    'unidades' => '',
    'fechaAlta' => '',
    'destacado' => false,
    'observaciones' => '',
    'correo' => '',
];
$errores = [];
$ficha = null;
$filas = [];
$resumen = [
    'titulos' => 0,
    'unidades' => 0,
    'paginas' => 0,
    'costeCentimos' => 0,
];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $agregarError = static function (string $campo, string $mensaje) use (&$errores): void {
        if (!array_key_exists($campo, $errores)) {
            $errores[$campo] = $mensaje;
        }
    };

    $leerTexto = static function (string $campo) use (&$valores, $agregarError): string {
        $valor = $_POST[$campo] ?? '';
        if (!is_string($valor)) {
            $agregarError($campo, 'El valor debe ser texto.');
            return '';
        }

        return trim($valor);
    };

    foreach (['tipo', 'titulo', 'autor', 'paginas', 'genero', 'unidades', 'fechaAlta', 'observaciones', 'correo'] as $campo) {
        $valores[$campo] = $leerTexto($campo);
    }

    foreach ([
        'titulo' => ['obligatorio' => 'El título es obligatorio.', 'maximo' => 120],
        'autor' => ['obligatorio' => 'El autor es obligatorio.', 'maximo' => 100],
        'observaciones' => ['maximo' => 300],
    ] as $campo => $reglas) {
        if (!isset($errores[$campo])) {
            if (isset($reglas['obligatorio']) && $valores[$campo] === '') {
                $agregarError($campo, $reglas['obligatorio']);
            } elseif (mb_strlen($valores[$campo], 'UTF-8') > $reglas['maximo']) {
                $agregarError($campo, 'Se ha superado la longitud máxima permitida.');
            }
        }
    }

    if (!isset($errores['tipo']) && !in_array($valores['tipo'], ['papel', 'digital'], true)) {
        $agregarError('tipo', 'Selecciona un tipo válido.');
    }
    if (!isset($errores['genero']) && !in_array($valores['genero'], ['ciencia', 'fantasia', 'terror'], true)) {
        $agregarError('genero', 'Selecciona un género válido.');
    }

    $paginas = null;
    if (!isset($errores['paginas'])) {
        $paginas = filter_var($valores['paginas'], FILTER_VALIDATE_INT);
        if ($paginas === false || $paginas < 1 || $paginas > 3000) {
            $paginas = null;
            $agregarError('paginas', 'Introduce un entero entre 1 y 3000.');
        }
    }

    $unidades = null;
    if (!isset($errores['unidades'])) {
        $unidades = filter_var($valores['unidades'], FILTER_VALIDATE_INT);
        if ($unidades === false || $unidades < 1 || $unidades > 50) {
            $unidades = null;
            $agregarError('unidades', 'Introduce un entero entre 1 y 50.');
        }
    }

    if (!isset($errores['correo'])) {
        if ($valores['correo'] === '' || filter_var($valores['correo'], FILTER_VALIDATE_EMAIL) === false) {
            $agregarError('correo', 'Introduce un correo electrónico válido.');
        }
    }

    $fechaAlta = null;
    if (!isset($errores['fechaAlta']) && $valores['fechaAlta'] !== '') {
        try {
            $fechaAlta = \DateTimeImmutable::createFromFormat('!Y-m-d', $valores['fechaAlta']);
        } catch (ValueError) {
            $fechaAlta = false;
        }

        if ($fechaAlta === false || $fechaAlta->format('Y-m-d') !== $valores['fechaAlta']) {
            $fechaAlta = null;
            $agregarError('fechaAlta', 'Introduce una fecha válida con formato YYYY-MM-DD.');
        }
    }

    if (array_key_exists('destacado', $_POST)) {
        if (is_string($_POST['destacado']) && $_POST['destacado'] === '1') {
            $valores['destacado'] = true;
        } else {
            $valores['destacado'] = false;
            $agregarError('destacado', 'El valor de destacado no es válido.');
        }
    }

    if ($errores === []) {
        try {
            $libro = $valores['tipo'] === 'papel'
                ? new LibroPapel(
                    $valores['titulo'],
                    $valores['autor'],
                    $paginas,
                    $valores['genero'],
                    $unidades,
                    $fechaAlta,
                    $valores['destacado'],
                    $valores['observaciones']
                )
                : new LibroDigital(
                    $valores['titulo'],
                    $valores['autor'],
                    $paginas,
                    $valores['genero'],
                    $unidades,
                    $fechaAlta,
                    $valores['destacado'],
                    $valores['observaciones']
                );
            $biblioteca->agregar($libro);
            $ficha = $biblioteca->filas([$libro])[0];
            $ficha['correo'] = $valores['correo'];
            $filas = $biblioteca->filas($biblioteca->todos());
            $resumen = $biblioteca->resumen($biblioteca->todos());
        } catch (\InvalidArgumentException $exception) {
            $errores['general'] = $exception->getMessage();
        }
    }
}

require dirname(__DIR__) . '/src/Vistas/alta.php';
