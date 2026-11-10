<?php
if (
    !isset($_GET['nombre'])
    || !is_string($_GET['nombre'])
    || preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $_GET['nombre']) !== 1
) {
    http_response_code(404);
    exit;
}

$directorio = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage'
    . DIRECTORY_SEPARATOR . 'carteles';
$ruta = $directorio . DIRECTORY_SEPARATOR . $_GET['nombre'];

if (!is_file($ruta) || !is_readable($ruta)) {
    http_response_code(404);
    exit;
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($ruta);
$mimesPermitidos = ['image/jpeg', 'image/png', 'image/webp'];

if ($mime === false || !in_array($mime, $mimesPermitidos, true)) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
readfile($ruta);
exit;