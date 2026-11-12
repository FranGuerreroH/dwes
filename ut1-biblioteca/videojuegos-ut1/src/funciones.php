<?php

declare(strict_types=1);

function normalizarTexto(string $texto): string
{
    // Quitamos espacios y ponemos a minúsculas
    return strtolower(trim($texto));
}

function buscarPorId(array $videojuegos, int $id): ?array
{
    // No sé bien qué pasa?¿
    foreach ($videojuegos as $videojuego) {
        if ($videojuego['id'] === $id) {
            return $videojuego;
        }
    }
    return null;
}

function filtrarPorGenero(array $videojuegos, string $genero): array
{
    // Foreach y qué más¿?

    $filtrado = [];
    foreach ($videojuegos as $videojuego) {
        // COMPLETAR
        // Cuidado con mayúsculas y minúsculas
        if ($videojuego['genero'] === $genero) {
            $filtrado[] = $videojuego;
        }
    }
    return $filtrado;
}

function filtrarPorPlataforma(array $videojuegos, string $plataforma): array
{
    // COMPLETAR
    $filtrado = [];
    // Igual que arriba
    foreach ($videojuegos as $videojuego) {
        if ($videojuego['plataforma'] === $plataforma) {
            $filtrado[] = $videojuego;
        }
    }
    return $filtrado;
}

function buscarPorTexto(array $videojuegos, string $texto): array
{
    $resultado = [];
    $texto = normalizarTexto($texto);

    foreach ($videojuegos as $videojuego) {
        $titulo = normalizarTexto($videojuego['titulo']);
        $estudio = normalizarTexto($videojuego['estudio']);

        // Esta función está implementada, pero su lógica no produce todos los resultados esperados.
        if (str_contains($estudio, $texto) || str_contains($titulo, $texto)) {
            $resultado[] = $videojuego;
        }
    }

    return $resultado;
}

function ordenarVideojuegos(array $videojuegos, string $criterio): array
{
    $criterio = normalizarTexto($criterio);
    $cantidad = count($videojuegos);

    for ($i = 0; $i < $cantidad; $i++) {
        for ($j = 0; $j < $cantidad - 1; $j++) {
            $actual = $videojuegos[$j][$criterio];
            $siguiente = $videojuegos[$j + 1][$criterio];

            // $intercambiar = match($criterio){
            //     'precio' => $actual['precio'] > $siguiente['precio'],
            //     'puntuacion' => $actual['puntuacion'] < $siguiente['puntuacion'],
            //     default => $actual['titulo'] > $siguiente['titulo']
            // };    Esto equivale a lo de abajo pero con match

            if ($actual < $siguiente) {
                // Aquí no ordenas, debes cambiar los registros:
                $temporal = $videojuegos[$j];
                $videojuegos[$j] = $videojuegos[$j + 1];
                $videojuegos[$j + 1] = $temporal;
            }
        }
    }
    return $videojuegos;
}
