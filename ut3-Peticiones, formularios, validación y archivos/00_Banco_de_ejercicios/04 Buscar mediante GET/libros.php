<?php
$busqueda = '';
$mensaje_error = '';
$mostrar_filtro = false;

if (isset($_GET['q'])) {
    
    if (is_array($_GET['q'])) {
        $mensaje_error = "Entrada no válida. Por favor, introduce un texto.";
    } else {
        $busqueda_limpia = trim($_GET['q']);
        
        if ($busqueda_limpia !== '') {
            $busqueda = $busqueda_limpia;
            $mostrar_filtro = true;
        }
    }
}



   