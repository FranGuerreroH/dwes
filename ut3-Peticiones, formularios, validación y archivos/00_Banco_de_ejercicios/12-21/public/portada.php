<?php

declare(strict_types=1);

$nombre = $_GET['nombre'] ?? '';
if (!is_string($nombre) || preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) !== 1) {
 http_response_code(404);
 exit;
}

$directorio = __DIR__ . '/../storage/portadas';
$ruta = $directorio . '/' . $nombre;

if (!is_file($ruta) || !is_readable($ruta)) {
 http_response_code(404);
 exit;
}

$mime = (new finfo(FILEINFO_MIME_TYPE))->file($ruta);

$permitidos = [
'image/jpeg' => 'jpg',
'image/png' => 'png',
'image/webp' => 'webp',
];

if ($mime === false || !isset($permitidos[$mime])) {
    $errores['portada'] = 'Formato no permitido.';
    } else {
    $extension = $permitidos[$mime];
}
$mime = is_file($ruta)
 ? (new finfo(FILEINFO_MIME_TYPE))->file($ruta) :
 false;
if (!in_array($mime, ['image/jpeg', 'image/png',
 'image/webp'], true)) {
 http_response_code(404);
 exit;
}
header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
readfile($ruta);
exit;


?>
