<?php

declare(strict_types=1);

require_once __DIR__ . '/src/datos.php';
require_once __DIR__ . '/src/cargar.php';

crearActividades();

$actividad101 = new ActividadGratuita(101, 'Actividad 101', 10, 5, EstadoActividad::Abierta, new Responsable(1,'Luis'));
$actividad103 = new ActividadPago(103, 'Actividad 103', 20, 10, EstadoActividad::Abierta, new Responsable(2,'Ana'), 2000);

$actividad101Importe = $actividad101->importe(2);
$actividad103Importe = $actividad103->importe(2);

echo "Importe de la actividad 101 para 2 unidades: $actividad101Importe centimos <br>";  
echo "Importe de la actividad 103 para 2 unidades: $actividad103Importe centimos <br>"; 

echo "El responsable de la actividad 101 es: " . $actividad101->responsable()->nombre() . "<br>";
echo "El responsable de la actividad 103 es: " . $actividad103->responsable()->nombre() . "<br>";

$actividad104 = new ActividadGratuita(104, 'Actividad 104', 15, 7, EstadoActividad::Abierta, null);
echo "El responsable de la actividad 104 es: " . ($actividad104->responsable() ? $actividad104->responsable()->nombre() : 'Ninguno') . "<br>";

echo $actividad101->etiqueta('Actividad: ') . "<br>";
echo $actividad101->responsable()->etiqueta('Responsable: ') . "<br>";

try{
    $actividad101->responsable()->nombre() = 'Pedro Felipe';
}catch(Error $e){
    echo "Error al intentar cambiar el nombre del responsable: " . $e->getMessage() . "<br>";
    echo "El nombre del responsable es: " . $actividad101->responsable()->nombre() . "<br>";
}

