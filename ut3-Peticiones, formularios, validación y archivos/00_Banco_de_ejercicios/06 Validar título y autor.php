<?php

$autor = $_GET['autor'];
$autor = strtolower(trim($autor));
$titulo = $_GET['titulo'];
$titulo = strtolower(trim($titulo));
$errores = [];

if (empty($titulo)) {
    $errores['titulo'] = "El título es obligatorio.";
} elseif (mb_strlen($titulo) === 3 && $titulo === "   ") {
    $errores['titulo'] = "El título no puede ser solo espacios.";
} elseif ($titulo === "a") {
    $errores['titulo'] = "El título no puede ser 'A'.";
} elseif (mb_strlen($titulo) > 120) {
    $errores['titulo'] = "El título no puede tener más de 120 caracteres.";
}

if (empty($autor)) {
    $errores['autor'] = "El autor es obligatorio.";
} elseif ($autor !== " ursula k. le guin ") {
    $errores['autor'] = "El autor no es válido.";
}
